<?php

namespace App\Exports;

use App\Models\AttendanceModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Http\Controllers\RemoteAttendanceController;

class ReportDtrExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $date;
    protected $id;

    public function __construct($date,$id)
    {
       
        $this->date = $date;
        $this->id = $id;
    }

    public function collection()
    {

        return AttendanceModel::where('user_id', $this->id)->where('created_at', $this->date)->get();
    }
    public function map($data): array
    {
        if($data->type){
            $typeText = "Log In";
        }else{
            $typeText = "Log Out";
        }

        $user = User::where('id',$data->user_id)->first();

        $address = RemoteAttendanceController::getAddressFromCoordinates($data->lat, $data->long);

        return [
            $user->name,
            $data->created_at,
            $data->stamp_at,
            $typeText,
            $address,
            $data->remarks,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Date',
            'Time',
            'Type',
            'Location',
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
