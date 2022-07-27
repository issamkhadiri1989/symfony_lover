<?php

namespace App\Controller;

use App\Repository\InterviewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class InterviewController
{
    public function __construct(private InterviewRepository $repository)
    {
    }

    #[Route(path: "/", name: "app_homepage")]
    public function index(): Response
    {
//        $dailyInterviews = $this->repository->listDailyInterviews();
        $dailyInterviews = $this->repository->interviewsOfTheYear();
        dd($dailyInterviews);

        return new Response();
    }
}