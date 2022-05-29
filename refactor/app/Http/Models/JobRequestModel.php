<?php namespace App\Http\Requests;

class JobRequestModel
{
    public int $jobId;
    public string $flagged;
    public string $sessionTime;
    public string $manuallyHandled;
    public string $byAdmin;
    public string $adminComment;

    public function __construct(Request $request)
    {
        $this->flagged = $request->get('flagged') == true ? 'yes' : 'no';
        $this->manuallyHandled = $request->get('manually_handled') == true ? 'yes' : 'no';
        $this->byAdmin = $request->get('by_admin') == true ? 'yes' : 'no';
        $this->jobId = $request->get('jobId');
        $this->sessionTime = $request->get('session_time');
        $this->adminComment = $request->get('admin_comment');
    }
}