<?php

namespace App\Http\Controllers;

use App\Models\Process;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Process $process)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        //
    }

    /**
     * Check or update process
     * with json return
     * */
    public function updateProcess($processId) {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        $response->setCallback(function() use ($processId) {
            $process = Process::find($processId);
            // if (!isset($process)){
            //     $t = "ON PROGRESS";
            //     $percentage = 2; 
            //     echo "data: " . $percentage.";".$t. "\n\n";
            //     ob_flush();
            //     flush();
            // }
            // else
            // {
                $percentage = round(($process->processed / $process->total) * 100);
                //echo "data: " . $percentage . "\n\n";
                $t = $process->status;
                echo "data: " . $percentage.";".$t. "\n\n";
                ob_flush();
                flush();
            //}
           
        });

        $response->send();

    }

    public function updateProcessWa($processId) {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        $response->setCallback(function() use ($processId) {
               $process = Process::find($processId);
            
                $percentage = round(($process->processed / $process->total) * 100);
                echo "data: " . $percentage . "\n\n";
                ob_flush();
                flush();
            
           
        });

        $response->send();

    }

    public function updateProcess2($processId) {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        $response->setCallback(function() use ($processId) {
            $process = Process::find($processId);
            $percentage = round(($process->processed / $process->total) * 100);
            //echo "data: " . $percentage . "\n\n";
            $t = $process->status;
            echo "data: " . $percentage.";".$t. "\n\n";
            ob_flush();
            flush();
        });

        $response->send();

    }

    public function updateProcess3($processId) {

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        $response->setCallback(function() use ($processId) {
               $process = Process::find($processId);
            
                $percentage = round(($process->processed / $process->total) * 100);
                echo "data: " . $percentage . "\n\n";
                ob_flush();
                flush();
            
           
        });

        $response->send();

    }
}
