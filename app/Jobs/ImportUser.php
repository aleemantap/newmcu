<?php

namespace App\Jobs;

//use App\Imports\UsersImport;
use App\Models\User;
use App\Models\Process;
use Exception;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    protected $processId;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $processId)
    {
        $this->filename = $filename;
        $this->processId = $processId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$this->filename);
            $reader = ReaderEntityFactory::createReaderFromFile($path);
            $reader->open($path);
            
            foreach ($reader->getSheetIterator() as $sheet) {
                if($sheet->getIndex() === 0) {
                    $this->calculateRow($sheet, $this->processId);
                    $this->readSheet($sheet, $this->processId);
                    break;
                }
            }
            
            $reader->close();
            
            // delete file
            unlink($path);
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    private function calculateRow($sheet, $processId)
    {
        $totalRow = 0;
        foreach($sheet->getRowIterator() as $i => $row) {
            $totalRow += 1;
        }
        
        $process = Process::find($processId);
        $process->total = $totalRow;
        $process->save();
    }
    
    private function readSheet($sheet, $processId)
    {
        foreach ($sheet->getRowIterator() as $i => $row) {
            
            $r = $row->toArray();
            
            $this->updateProcess($processId, $i);
            
            // Find user
            $userExists = User::where('email', $r[1])->count();
            if($userExists > 0) {
                continue;
            }
            
            User::create(
                [
                    'email'         => $r[1],
                    'name'          => $r[0],
                    'password'      => Hash::make($r[2]),
                    'user_group_id' => $r[3],
                    'active'        => $r[4]
                ]
            );
            
            
        }
    }
    
    private function updateProcess($processId, $i)
    {
        $process = Process::find($processId);
        $process->processed = $i;
        $process->success = $i;

        if($process->total == $i) {
            $process->status = 'DONE';
        }

        $process->save();
    }
}
