<?php

namespace app\services;

use app\forms\EmployeeCreateForm;
use app\forms\InterviewJoinForm;
use app\forms\InterviewMoveForm;
use app\forms\InterviewRejectForm;
use app\forms\InterviewUpdateForm;
use app\models\Contract;
use app\models\Employee;
use app\models\Interview;
use app\models\Order;
use app\models\Recruit;
use app\repositories\ContractRepositoryInterface;
use app\repositories\EmployeeRepositoryInterface;
use app\repositories\InterviewRepositoryInterface;
use app\repositories\OrderRepositoryInterface;
use app\repositories\RecruitRepositoryInterface;
use yii\web\ServerErrorHttpException;

class StaffService
{
    private $interviewRepository;
    private $employeeRepository;
    private $logger;
    private $notifier;
    private $orderRepository;
    private $contractRepository;
    private $recruitRepository;
    private $transactionManager;

    public function __construct(
        InterviewRepositoryInterface $interviewRepository,
        EmployeeRepositoryInterface $employeeRepository,
        OrderRepositoryInterface $orderRepository,
        ContractRepositoryInterface $contractRepository,
        RecruitRepositoryInterface $recruitRepository,
        TransactionManager $transactionManager,
        LoggerInterface $logger,
        NotifierInterface $notifier
    )
    {
        $this->interviewRepository = $interviewRepository;
        $this->employeeRepository = $employeeRepository;
        $this->orderRepository = $orderRepository;
        $this->contractRepository = $contractRepository;
        $this->recruitRepository = $recruitRepository;
        $this->transactionManager = $transactionManager;
        $this->logger = $logger;
        $this->notifier = $notifier;
    }

    public function joinToInterview(InterviewJoinForm $form)
    {
        $interview = Interview::create($form->firstName, $form->lastName, $form->email, $form->date);
        $this->interviewRepository->add($interview);
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
        $this->interviewRepository->save($interview);
        $this->logger->log("Interview {$interview->id} is updated");
    }

    public function moveInterview(Interview $interview, InterviewMoveForm $form)
    {
        $interview->move($form->date);
        $this->interviewRepository->save($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/move', ['model' => $interview, 'moveForm' => $form],
                $interview->email,"You interview is moved to {$interview->date}");
        }
        $this->logger->log("Interview {$interview->id} date is moved");
    }

    public function rejectInterview(Interview $interview, InterviewRejectForm $form)
    {
        $interview->reject($form->reason);
        $this->interviewRepository->save($interview);
        if($interview->email) {
            $this->notifier->notify('/interview/reject', ['model' => $interview, 'rejectForm' => $form],
                $interview->email,'You are failed an interview');
        }
        $this->logger->log("Interview {$interview->id} is rejected");
    }

    /**
     * @param EmployeeCreateForm $form
     * @param Interview $interview
     * @return Employee
     * @throws \Exception
     */
    public function createEmployee(EmployeeCreateForm $form, Interview $interview)
    {
        $transaction = $this->transactionManager->begin();
        try {
            $employee = Employee::create($form->firstName, $form->lastName, $form->address, $form->email);
            $this->employeeRepository->add($employee);
            if ($interview) {
                $interview->pass($employee->id);
                $this->interviewRepository->save($interview);
            }

            $order = Order::create($form->orderDate);
            $this->orderRepository->add($order);

            $contract = Contract::create($employee->id, $form->firstName, $form->lastName, $form->contractDate);
            $this->contractRepository->add($contract);

            $recruit = Recruit::create($order->id, $employee->id, $form->recruitDate);
            $this->recruitRepository->add($recruit);

            $this->logger->log("Employee {$employee->id} is created");
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $employee;
    }
}