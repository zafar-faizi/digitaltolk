<?php

namespace DTApi\Repository;

/**
 * Class BookingRepository
 * @package DTApi\Repository
 */
class JobRepository extends BaseRepository
{

    protected Job $jobModel;
    protected MailerInterface $mailer;
    protected Logger $logger;

    public function __construct(
        Job $jobModel,
        MailerInterface $mailer,
        Logger $logger
    )
    {
        parent::__construct($jobModel);
        $this->mailer = $mailer;
        $this->jobModel = $jobModel;
    }

    /**
     * @param $user_id
     * @return array
     */
    public function getJobsByUserId($user_id)
    {
        $user = User::findOrFail($user_id);

        if ($user->isCustomer())
        {
            return $this->processJobs(
                $this->getCustomerJobs($user)
            );
        }
        else if ($user->isTranslator())
        {
            return $this->processJobs(
                Job::getTranslatorJobs($user->id, 'new')
                    ->pluck('jobs')
                    ->all()
            );
        }

        throw new InvalidUserIdProvidedException('User is neither customer nor translator');
    }

    public function updateJob(JobRequestModel $job): Job
    {
        return Job::where('id', '=', $job->jobId)
            ->update([
                'admin_comments'   => $job->adminComment,
                'flagged'          => $job->flagged,
                'session_time'     => $job->session,
                'manually_handled' => $job->manuallyHandled,
                'by_admin'         => $job->byAdmin
            ]);
    }

    private function processJobs(Collection $jobs, User $user): JobResponseModel
    {
        foreach ($jobs as $jobitem)
        {
            if ($jobitem->immediate == 'yes')
            {
                $emergencyJobs[] = $jobitem;
            }
            else
            {
                $normalJobs[] = $jobitem;
            }
        }

        // this could also be refactored further
        $normalJobs = Job::getParticularsJobs($user->getId(), collect($normalJobs))
            ->sortBy('due')
            ->all();

        return new JobResponseModel(
            $emergencyJobs,
            $normalJobs,
            $user,
            $user->isCustomer() ? 'customer' : 'translator'
        );
    }

    private function getCustomerJobs(User $user): Model
    {
        return $user->jobs()
            ->with('user.userMeta', 'user.average', 'translatorJobRel.user.average', 'language', 'feedback')
            ->whereIn('status', ['pending', 'assigned', 'started'])
            ->orderBy('due', 'asc')
            ->get();
    }
}