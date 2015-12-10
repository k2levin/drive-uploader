<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib\GoogleApiManager\GoogleApiManager;

class DriveController extends Controller
{
    /**
     * GoogleApiManager
     * @var GoogleApiManager
     */
    protected $GoogleApiManager;

    /**
     * constructor
     * @param GoogleApiManager $GoogleApiManager
     */
    public function __construct(GoogleApiManager $GoogleApiManager)
    {
        $this->GoogleApiManager = $GoogleApiManager;
    }

    /**
     * drive index with folders & files
     * @param  string $folder_id
     * @return mixed
     */
    public function listFiles($folder_id = '')
    {
        $file_lists = $this->GoogleApiManager->listFiles($folder_id);

        return view('drive.index', compact('file_lists'));
    }

    /**
     * file upload form
     * @param  string $folder_id
     * @return mixed
     */
    public function upload($folder_id)
    {
        return view('drive.upload', compact('folder_id'));
    }

    /**
     * post with file upload form
     * @param  Request $request
     * @param  string  $folder_id
     * @return mixed
     */
    public function postUpload(Request $request, $folder_id)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $File = $request->file('file');
            $file_name = $request->get('name');
            $results = $this->GoogleApiManager->upload($folder_id, $File, $file_name);
        }

        if (isset($results->id)) {
            return redirect()->route('list_files')->with('flash_success', 'File uploaded successfully');
        } else {
            return redirect()->route('list_files')->with('flash_error', $results['error']);
        }
    }

    /**
     * set file / folder which anyone with the link can view
     * @param  string $file_id
     * @return mixed
     */
    public function enablePublic($file_id)
    {
        $result = $this->GoogleApiManager->enablePublic($file_id);

        if ($result === 'success') {
            return redirect()->route('list_files')->with('flash_success', 'Enabled public successfully');
        } else {
            return redirect()->route('list_files')->with('flash_error', $result);
        }
    }

    /**
     * unset file / folder which anyone with the link can view
     * @param  string $file_id
     * @return mixed
     */
    public function disablePublic($file_id)
    {
        $result = $this->GoogleApiManager->disablePublic($file_id);

        if ($result === 'success') {
            return redirect()->route('list_files')->with('flash_success', 'Disabled public successfully');
        } else {
            return redirect()->route('list_files')->with('flash_error', $result);
        }
    }

    /**
     * delete file
     * @param  string $file_id
     * @return mixed          
     */
    public function delete($file_id)
    {
        $result = $this->GoogleApiManager->delete($file_id);

        if ($result === 'success') {
            return redirect()->route('list_files')->with('flash_success', 'Deleted successfully');
        } else {
            return redirect()->route('list_files')->with('flash_error', $result);
        }
    }
}
