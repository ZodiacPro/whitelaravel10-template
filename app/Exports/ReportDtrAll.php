<?php

namespace App\Exports;

use App\Models\AttendanceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use Auth;
use App\Models\AttendanceViewModel;
use App\Models\User;

class ReportDtrAll implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $inDate;
    protected $OutDate;

    public function __construct($inDate, $OutDate)
    {
       
        $this->inDate = $inDate;
        $this->OutDate = $OutDate;
    }

    public function collection()
    {
       
        $access = Auth::user()->company;
        if($access == 0){
            return AttendanceViewModel::whereBetween('date',[$this->inDate,$this->OutDate])->get();
        }else{
            
            return AttendanceViewModel::whereBetween('date',[$this->inDate,$this->OutDate])->where('company', Auth::user()->company)->get();
        }
        
    }
    public function map($data): array
    {
        $user = User::where('id',$data->user_id)->first();

        return [
            $user->name,
            $data->date,
            $data->LogIn,
            $data->LogOut,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Date',
            'Log IN',
            'Log Out',
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
                $event->sheet->setCellValue('A1', 'Attendance Log');
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
