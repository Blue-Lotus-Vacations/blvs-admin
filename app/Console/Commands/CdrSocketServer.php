<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CallLog;
use Illuminate\Support\Carbon;

class CdrSocketServer extends Command
{
    protected $signature = 'cdr:listen {host=127.0.0.1} {port=3000}';
    protected $description = 'Listen for incoming 3CX CDR data via TCP socket';

    public function handle()
    {
        $host = $this->argument('host');
        $port = $this->argument('port');

        $this->info("📡 Listening on $host:$port ...");

        $server = stream_socket_server("tcp://$host:$port", $errno, $errstr);
        if (!$server) {
            $this->error("❌ Failed to create socket: $errstr ($errno)");
            return;
        }

        while ($conn = @stream_socket_accept($server)) {
            $line = trim(fgets($conn));
            fclose($conn);

            $fields = str_getcsv($line);
            if (count($fields) < 9) continue;

            [$id, $direction, $caller, $callee, $ext, $start, $answer, $end, $reason] = $fields;

            if ($reason === 'NoAnswer') {
                CallLog::create([
                    'caller_number' => $caller,
                    'agent_extension' => $ext,
                    'missed_at' => Carbon::createFromFormat('d/m/Y H:i:s', $end, 'UTC'),
                    'status' => 'missed',
                ]);

                $this->info("✅ Missed call logged from $caller → $ext");
            } else {
                $this->info("ℹ️ Call ended with reason: $reason");
            }
        }
    }
}
