<?php

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

            if (empty($line)) continue;

            $this->warn("🔍 Raw data: " . $line);

            $fields = str_getcsv($line);

            // Pad array to ensure 27 keys exist (fill missing ones with null)
            $fields = array_pad($fields, 27, null);

            try {
                CallLog::create([
                    'historyid'           => $fields[0],
                    'callid'              => $fields[1],
                    'duration'            => $fields[2],
                    'time_start'          => $fields[3],
                    'time_answered'       => $fields[4],
                    'time_end'            => $fields[5],
                    'reason_terminated'   => $fields[6],
                    'from_no'             => $fields[7],
                    'to_no'               => $fields[8],
                    'from_dn'             => $fields[9],
                    'to_dn'               => $fields[10],
                    'dial_no'             => $fields[11],
                    'reason_changed'      => $fields[12],
                    'final_number'        => $fields[13],
                    'final_dn'            => $fields[14],
                    'bill_code'           => $fields[15],
                    'bill_rate'           => $fields[16],
                    'bill_cost'           => $fields[17],
                    'bill_name'           => $fields[18],
                    'chain'               => $fields[19],
                    'from_type'           => $fields[20],
                    'to_type'             => $fields[21],
                    'final_type'          => $fields[22],
                    'from_dispname'       => $fields[23],
                    'to_dispname'         => $fields[24],
                    'final_dispname'      => $fields[25],
                    'missed_queue_calls'  => $fields[26],
                ]);

                $this->info("✅ Call saved: {$fields[7]} → {$fields[8]}");
            } catch (\Exception $e) {
                $this->error("❌ Error saving call: " . $e->getMessage());
            }
        }
    }
}
