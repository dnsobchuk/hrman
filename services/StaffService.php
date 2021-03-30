<?php

namespace app\services;

use app\models\Interview;
use app\repositories\InterviewRepositoryInterface;

class StaffService
{
    private $repository;
    private $logger;
    private $notifier;

    public function __construct(
        InterviewRepositoryInterface $interviewRepository,
        LoggerInterface $logger,
        NotifierInterface $notifier
    )
    {
        $this->repository = $interviewRepository;
        $this->logger = $logger;
        $this->notifier = $notifier;
    }

    public function joinToInterview($form)
    {
        $interview = Interview::create($form->firstName, $form->lastName, $form->email, $form->date);
        $this->repository->add($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/join', ['model' => $interview, 'joinForm' => $form], $interview->email,
                'You are joined to interview!');
        }
        $this->logger->log("Interview {$interview->id} is created");
        return $interview;
    }

    public function updateInterview($id, $lastName, $firstName, $email)
    {

        /** @var Interview $interview */
        $interview = $this->repository->find($id);
        $interview->editData($lastName, $firstName, $email);
        $this->repository->save($interview);
        $this->logger->log("Interview {$interview->id} is updated");
    }

    public function rejectInterview($id, $form)
    {
        /** @var Interview $interview */
        $interview = $this->repository->find($id);
        $interview->reject($form->reason);
        $this->repository->save($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/reject', ['model' => $interview, 'rejectForm' => $form],
                $interview->email,'You are failed an interview');
        }
        $this->logger->log("Interview {$interview->id} is updated");
    }
}