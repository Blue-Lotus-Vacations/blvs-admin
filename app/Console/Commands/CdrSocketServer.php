<?php

// app/Console/Commands/CdrSocketServer.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CallLog;

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
            $this->warn("🔍 Raw data: " . $line);

            $fields = str_getcsv($line);


            try {
                CallLog::create([
                    'historyid'            => $fields[0] ?? null,
                    'callid'               => $fields[1] ?? null,
                    'duration'             => $fields[2] ?? null,
                    'time_start'           => $fields[3] ?? null,
                    'time_answered'        => $fields[4] ?? null,
                    'time_end'             => $fields[5] ?? null,
                    'reason_terminated'    => $fields[6] ?? null,
                    'from_no'              => isset($fields[7]) ?? null,
                    'to_no'                => $fields[8] ?? null,
                    'from_dn'              => $fields[9] ?? null,
                    'to_dn'                => $fields[10] ?? null,
                    'dial_no'              => $fields[11] ?? null,
                    'reason_changed'       => $fields[12] ?? null,
                    'final_number'         => $fields[13] ?? null,
                    'final_dn'             => $fields[14] ?? null,
                    'bill_code'            => $fields[15] ?? null,
                    'bill_rate'            => $fields[16] ?? null,
                    'bill_cost'            => $fields[17] ?? null,
                    'bill_name'            => $fields[18] ?? null,
                    'chain'                => $fields[19] ?? null,
                    'from_type'            => $fields[20] ?? null,
                    'to_type'              => $fields[21] ?? null,
                    'final_type'           => $fields[22] ?? null,
                    'from_dispname'        => $fields[23] ?? null,
                    'to_dispname'          => $fields[24] ?? null,
                    'final_dispname'       => $fields[25] ?? null,
                    'missed_queue_calls'   => $fields[26] ?? null,
                ]);

                $this->info("✅ Call saved: {$fields[7]} → {$fields[8]}");
            } catch (\Exception $e) {
                $this->error("❌ Error saving call: " . $e->getMessage());
            }
        }
    }
}
