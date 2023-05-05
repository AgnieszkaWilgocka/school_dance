<?php

namespace App\Service;

use App\Entity\Dance;
use App\Repository\DanceRepository;

class DanceService implements DanceServiceInterface
{
    private DanceRepository $danceRepository;

    public function __construct(DanceRepository $danceRepository)
    {
        $this->danceRepository = $danceRepository;
    }

    public function save(Dance $dance): void
    {
        $this->danceRepository->save($dance);
    }

    public function delete(Dance $dance): void
    {
        $this->danceRepository->delete($dance);
    }
}
