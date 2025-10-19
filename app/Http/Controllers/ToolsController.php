<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Process;
use App\Antrovisus;
use App\Mcu;
use App\Fisik;
use App\Audiometri;
use App\Diagnosis;
use App\Umum;
use App\Riwayat;
use App\Hematologi;
use App\Kimia;
use App\Oae;
use App\Rontgen;
use App\Serologi;
use App\Spirometri;
use App\Treadmill;
use App\Feses;
use App\Urin;
use App\PapSmear;
use App\Ekg;
use App\RectalSwab;
use App\DrugScreening;
use App\AudiometriDetail;
use App\RontgenDetail;
use App\Reportsendwa;
use Carbon\Carbon;

use Screen\Capture;

class ToolsController extends Controller
{
    public function backupDatabase()
    {
       
		return view('pages.tools.backup', [
            'tables' => DB::select("show tables")
        ]);
    }

    public function restoreDatabase()
    {
        return view('pages.tools.restore');
    }
	
	public function byIdDelete($id){
		 
		try { 
			$process = Process::where('id',$id)->delete();
			$antrovisus = Antrovisus::where('process_id',$id)->delete();
			$mcu = Mcu::where('process_id',$id)->delete();
			$fisik = Fisik::where('process_id',$id)->delete();
			$audiometri = Audiometri::where('process_id',$id)->delete();
			$diagnoses = Diagnosis::where('process_id',$id)->delete();
			$umum = Umum::where('process_id',$id)->delete();
			$riwayat = Riwayat::where('process_id',$id)->delete();
			$hematologi = Hematologi::where('process_id',$id)->delete();
			$kimia = Kimia::where('process_id',$id)->delete();
			$aae = Oae::where('process_id',$id)->delete();
			$rontgen = Rontgen::where('process_id',$id)->delete();
			$serologi = Serologi::where('process_id',$id)->delete();
			$spirometri = Spirometri::where('process_id',$id)->delete();
			$treadmill = Treadmill::where('process_id',$id)->delete();
			$feses = Feses::where('process_id',$id)->delete();
			$urin = Urin::where('process_id',$id)->delete();
			$PapSmear = PapSmear::where('process_id',$id)->delete();
			$ekg = Ekg::where('process_id',$id)->delete();
			$rectalSwab = RectalSwab::where('process_id',$id)->delete();
			$DrugScreening = DrugScreening::where('process_id',$id)->delete();
			$AudiometriDetail = AudiometriDetail::where('process_id',$id)->delete();
			$RontgenDetail = RontgenDetail::where('process_id',$id)->delete();
			$wa = Reportsendwa::where('process_id',$id)->delete(); 
			
			
		
			
			 return response()->json([
                'success' => 1,
                'responseCode' => 200,
                'responseMessage' => 'Truncate table By Id successfully',
                'processId' => $id
            ]); 
			
		} catch (Exception $ex) {
                return response()->json(['success' => 0,'responseCode' => 500, 'responseMessage' => "Failed"]);
		}
   }
	
	public function truncatetable()
	{
		 DB::table('failed_jobs')->truncate();
		 DB::table('antrovisus')->truncate();
		 DB::table('audiometri')->truncate();
		 DB::table('audiometri_details')->truncate();
		 DB::table('diagnoses')->truncate();
		 DB::table('drug_screening')->truncate();
		 DB::table('drug_screening_details')->truncate();
		 DB::table('ekg')->truncate();
		 DB::table('feses')->truncate();
		 DB::table('fisik')->truncate();
		 DB::table('hematologi')->truncate();
		 DB::table('kimia')->truncate();
		 DB::table('mcu')->truncate();
		 DB::table('oae')->truncate();
		 DB::table('pap_smear')->truncate();
		 DB::table('processes')->truncate();
		 DB::table('rectal_swab')->truncate();
		 DB::table('riwayat')->truncate();
		 DB::table('rontgen')->truncate();
		 DB::table('rontgen_details')->truncate();
		 DB::table('serologi')->truncate();
		 DB::table('spirometri')->truncate();
		 DB::table('treadmill')->truncate();
		 DB::table('umum')->truncate();
		 DB::table('urin')->truncate();
		 DB::table('jobs')->truncate();
		 DB::table('reportsendwa')->truncate();
		 return response()->json(['responseCode' => 200, 'responseMessage' => 'Truncate table successfully']);
	}
	
	function serverDBBackup($nama)
    {
       //ENTER THE RELEVANT INFO BELOW
       $mysqlHostName      = env('DB_HOST');
       $mysqlUserName      = env('DB_USERNAME');
       $mysqlPassword      = env('DB_PASSWORD');
       $DbName             = env('DB_DATABASE');
       $file_name = $nama.".sql";;//'database_backup_on_' . date('y-m-d') . '.sql';


       $queryTables = \DB::select(\DB::raw('SHOW TABLES'));
        foreach ( $queryTables as $table )
        {
            foreach ( $table as $tName)
            {
                $tables[]= $tName ;
            }
        }
      // $tables  = array("users","products","categories"); //here your tables...

       $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
       $get_all_table_query = "SHOW TABLES";
       $statement = $connect->prepare($get_all_table_query);
       $statement->execute();
       $result = $statement->fetchAll();
       $output = '';
       foreach($tables as $table)
       {
           $show_table_query = "SHOW CREATE TABLE " . $table . "";
           $statement = $connect->prepare($show_table_query);
           $statement->execute();
           $show_table_result = $statement->fetchAll();

           foreach($show_table_result as $show_table_row)
           {
               $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
           }
           $select_query = "SELECT * FROM " . $table . "";
           $statement = $connect->prepare($select_query);
           $statement->execute();
           $total_row = $statement->rowCount();

           for($count=0; $count<$total_row; $count++)
           {
               $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
               $table_column_array = array_keys($single_result);
               $table_value_array = array_values($single_result);
               $output .= "\nINSERT INTO $table (";
               $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
               $output .= "'" . implode("','", $table_value_array) . "');\n";
           }
       }

       $file_handle = fopen($file_name, 'w+');
       fwrite($file_handle, $output);
       fclose($file_handle);
       header('Content-Description: File Transfer');
       header('Content-Type: application/octet-stream');
       header('Content-Disposition: attachment; filename=' . basename($file_name));
       header('Content-Transfer-Encoding: binary');
       header('Expires: 0');
       header('Cache-Control: must-revalidate');
       header('Pragma: public');
       header('Content-Length: ' . filesize($file_name));
       ob_clean();
       flush();
       readfile($file_name);
       unlink($file_name);
   }
	
    public function restore(Request $request){
		
			if($request->hasFile('file')) {

				$file = $request->file('file');
				if($file->isValid()) {
					
					//if($d->foto !="")
					//{
					//		Storage::disk('s3')->delete('ekg/'. $d->foto);
					//}
					
					//$nameStripped = $request->id.'-'.time().str_replace(" ", "-","ekg" ); //$file->getClientOriginalName()
					//$file->storeAs('upload', $nameStripped,'public');
					//Storage::disk('')->put('ekg/' . $nameStripped, file_get_contents($file));
					 
					//$d->foto  = $nameStripped;
					
					//if(!$d->save()) {
					//	return response()->json(['responseCode' => 500, 'responseMessage' => 'Gagal menyimpan foto EKG']);
					//}

					//return response()->json(['responseCode' => 200, 'responseMessage' => 'Foto EKG berhasil disimpan']);
					try {
						$DB_HOST = env("DB_HOST", "");
						$DB_DATABASE = env("DB_DATABASE", "");
						$DB_USERNAME = env("DB_USERNAME", "");
						$DB_PASSWORD = env("DB_PASSWORD", "");
						$connection = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
					
						$handle = fopen($file, "r+");
                        $contents = fread($handle, filesize($file));
                        $sql = explode(';', $contents);
                        $flag = 0;
                        foreach ($sql as $query) {
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                $flag = 1;
                            }
                        }
                        fclose($handle);
						return response()->json(['responseCode' => 200, 'responseMessage' => 'Restore Database berhasil !!']);
					}catch (\Exception $e) {
					
						return response()->json(['responseCode' => 404, 'responseMessage' => $e]);
						
					}
				}

			}
			else
			{
				return response()->json(['responseCode' => 500, 'responseMessage' => 'File Kosong']);
			}
		
	}
    public function restorex($nama)
    {
                try {
                    
                    $DB_HOST = env("DB_HOST", "");
                    $DB_DATABASE = env("DB_DATABASE", "");
                    $DB_USERNAME = env("DB_USERNAME", "");
                    $DB_PASSWORD = env("DB_PASSWORD", "");
                    $connection = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
    
                    $file = config('backup.backup.name') . '/' . $file_name;
                    $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
                    if ($disk->exists($file)) {
                        $fs = Storage::disk(config('backup.backup.destination.disks')[0])->getDriver();
                        
                        $handle = fopen($file, "r+");
                        $contents = fread($handle, filesize($file));
                        $sql = explode(';', $contents);
                        $flag = 0;
                        foreach ($sql as $query) {
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                $flag = 1;
                            }
                        }
                        fclose($handle);
                    } else {
                        abort(404, "The backup file doesn't exist.");
                    }
                   
                    if ($flag) {
                        Toastr::success('Operation successful', 'Success');
                        return redirect()->back();
                    } else {
                        Toastr::error('Operation Failed', 'Failed');
                        return redirect()->back();
                    }
                } catch (\Exception $e) {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
     }	
	 
	  public function moveLog(){
		    $localDisk = Storage::disk('log'); //getting log disk instance
    		$localFiles = $localDisk->allFiles('logs'); // getting all log files in from location storage/logs
    		$cloudDisk = Storage::disk('s3'); //getting instance of “s3” disk
    		$pathPrefix = 'backup-logs' . DIRECTORY_SEPARATOR . Carbon::now() . DIRECTORY_SEPARATOR;  // setting target path for log files.
    		foreach ($localFiles as $file) 
                {
    			$contents = $localDisk->get($file);
    			$cloudLocation = $pathPrefix . $file;
    			$cloudDisk->put($cloudLocation, $contents);
    			$localDisk->delete($file);
    		} // moving log files into s3 bucket.
		  
	  }
	  
	   public function deleteLog(){
		   //Storage::disk('s3')->delete('backup-logs');
		   Storage::disk('s3')->deleteDirectory('/backup-logs');
	   }
	   
	   public function deleteProsesBysID($id) 
	   {
		  $d=  DB::table('processes')->where('id',$id)->delete(); //97
		  if($d)
		  {
			  return response()->json(['responseCode' => 200, 'responseMessage' => 'Sukses']);
		  }
		  else
		  {
			  return response()->json(['responseCode' => 500, 'responseMessage' => 'Gagal']);
		  }
	   }
	
}
