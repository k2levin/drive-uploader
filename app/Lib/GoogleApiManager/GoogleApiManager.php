<?php

namespace App\Lib\GoogleApiManager;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_ParentReference;
use Google_Service_Drive_Permission;

class GoogleApiManager
{
    /**
     * Google_Client
     * @var Google_Client
     */
    protected $client;

    /**
     * Constructor
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $client_id     = env('GOOGLE_API_CLIENT_ID', '');
        $client_secret = env('GOOGLE_API_CLIENT_SECRET', '');
        $redirect_uri  = env('GOOGLE_API_REDIRECT_URI', '');
        $refresh_token = env('GOOGLE_API_REFRESH_TOKEN', '');

        $this->client = $client;
        $this->client->setClientId($client_id);
        $this->client->setClientSecret($client_secret);
        $this->client->setRedirectUri($redirect_uri);

        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshToken($refresh_token);
        }
    }

    /**
     * get Google_Service_Drive
     * @return Google_Service_Drive
     */
    public function getDriveService()
    {
        return new Google_Service_Drive($this->client);
    }

    /**
     * get Google_Client
     * @return Google_Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Drive index with folder & file
     * @param  string $folder_id
     * @return array
     */
    public function listFiles($folder_id)
    {
        $file_lists = array();
        $parent_id = '';

        $FileLists = $this->getDriveService()->files->listFiles();

        if ($folder_id === '') {
            foreach ($FileLists as $key => $FileList) {
                if (isset($FileList->parents[0]->isRoot) && $FileList->parents[0]->isRoot === true) {
                    $this->setFileLists($FileList, $key, $file_lists);
                }
            }
        } else {
            foreach ($FileLists as $key => $FileList) {
                if (isset($FileList->parents[0]->id) && $FileList->parents[0]->id === $folder_id) {
                    $this->setFileLists($FileList, $key, $file_lists);
                }
            }
        }

        return $file_lists;
    }

    /**
     * set file lists
     * @param mixed $FileList
     * @param string $key
     * @param array $file_lists
     */
    private function setFileLists($FileList, $key, &$file_lists)
    {
        $file_lists['parent_id'] = $FileList->parents[0]->id;

        if ($FileList->mimeType === 'application/vnd.google-apps.folder') {
            $file_lists['folders'][$key]['id']       = $FileList->id;
            $file_lists['folders'][$key]['title']    = $FileList->title;
            $file_lists['folders'][$key]['mimeType'] = $FileList->mimeType;
            $file_lists['folders'][$key]['iconLink'] = $FileList->iconLink;
            $file_lists['folders'][$key]['shared']   = $FileList->shared;
        } else {
            $file_lists['files'][$key]['id']       = $FileList->id;
            $file_lists['files'][$key]['title']    = $FileList->title;
            $file_lists['files'][$key]['mimeType'] = $FileList->mimeType;
            $file_lists['files'][$key]['iconLink'] = $FileList->iconLink;
            $file_lists['files'][$key]['shared']   = $FileList->shared;
        }
    }

    /**
     * upload file
     * @param  string $folder_id
     * @param  mixed $File
     * @param  string $file_name
     * @return mixed
     */
    public function upload($folder_id, $File, $file_name)
    {
        $DriveFile = new Google_Service_Drive_DriveFile();
        $Parent = new Google_Service_Drive_ParentReference();

        if ($file_name === '') $file_name = $File->getClientOriginalName();

        $DriveFile->setTitle($file_name);
        $Parent->setId($folder_id);
        $DriveFile->setParents([$Parent]);

        try {
            $results = $this->getDriveService()->files->insert($DriveFile, [
                'data'       => file_get_contents($File),
                'mimeType'   => 'application/octet-stream',
                'uploadType' => 'multipart'
            ]);
        } catch (\Exception $e) {
            $results['error'] = $e->getMessage();
        }

        return $results;
    }

    /**
     * set file / folder which anyone with the link can view
     * @param  string $file_id
     * @return mixed
     */
    public function enablePublic($file_id)
    {
        try {
            $DrivePermission = new Google_Service_Drive_Permission();
            $DrivePermission->setType('anyone');
            $DrivePermission->setRole('reader');
            $DrivePermission->setWithLink(true);

            $results = $this->getDriveService()->permissions->insert($file_id, $DrivePermission);

            return 'success';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * unset file / folder which anyone with the link can view
     * @param  string $file_id
     * @return mixed
     */
    public function disablePublic($file_id)
    {
        try {
            $results = $this->getDriveService()->permissions->delete($file_id, 'anyoneWithLink');

            return 'success';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * delete file
     * @param  string $file_id
     * @return mixed
     */
    public function delete($file_id)
    {
        try {
            $this->getDriveService()->files->delete($file_id);

            return 'success';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
