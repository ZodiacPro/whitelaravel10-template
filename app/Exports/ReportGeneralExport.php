<?php

namespace App\Exports;

use App\Models\User;
use App\Models\IterinaryLog;
use App\Models\AttendanceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportGeneralExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return User::all();
    }
    public function map($user): array
    {
        $sched = IterinaryLog::where('user_id',$user->id)->where('date',$this->date)->count();
        $actual = AttendanceModel::where('user_id',$user->id)
                                            ->where('created_at',$this->date)
                                            ->where('type',0)
                                            ->count();
        if(!$sched) $sched = "0";
        if(!$actual) $actual = "0";
        return [
            $user->name,
            $user->email,
            $sched,
            $actual,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Scheduled Appointment',
            'Actual Appointment',
        ];
    }

    public function startCell(): string
    {
        return 'A2'; // Start the data at A2
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A1', 'Users Data');
                $event->sheet->mergeCells('A1:C1');
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ]);
            },
        ];
    }
}
