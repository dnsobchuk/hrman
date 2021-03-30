<?php

namespace app\services;

use app\forms\InterviewJoinForm;
use app\forms\InterviewMoveForm;
use app\forms\InterviewRejectForm;
use app\forms\InterviewUpdateForm;
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

    public function joinToInterview(InterviewJoinForm $form)
    {
        $interview = Interview::create($form->firstName, $form->lastName, $form->email, $form->date);
        $this->repository->add($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/join', ['model' => $interview, 'joinForm' => $form],
                $interview->email,'You are joined to interview!');
        }
        $this->logger->log("Interview {$interview->id} is created");
        return $interview;
    }

    public function updateInterview(Interview $interview, InterviewUpdateForm $form)
    {
        $interview->editData($form->lastName, $form->firstName, $form->email);
        $this->repository->save($interview);
        $this->logger->log("Interview {$interview->id} is updated");
    }

    public function moveInterview(Interview $interview, InterviewMoveForm $form)
    {
        $interview->move($form->date);
        $this->repository->save($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/move', ['model' => $interview, 'moveForm' => $form],
                $interview->email,"You interview is moved to {$interview->date}");
        }
        $this->logger->log("Interview {$interview->id} date is moved");
    }

    public function rejectInterview(Interview $interview, InterviewRejectForm $form)
    {
        $interview->reject($form->reason);
        $this->repository->save($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/reject', ['model' => $interview, 'rejectForm' => $form],
                $interview->email,'You are failed an interview');
        }
        $this->logger->log("Interview {$interview->id} is rejected");
    }
}