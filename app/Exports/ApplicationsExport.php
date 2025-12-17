<?php 
 
namespace App\Exports; 
 
use App\Models\Application; 
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\WithHeadings; 
use Maatwebsite\Excel\Concerns\WithMapping; 
 
class ApplicationsExport implements FromCollection, WithHeadings, 
WithMapping 
{ 
    public function collection() 
    { 
        return Application::with(['user', 'job'])->get(); 
    } 
     
    public function headings(): array 
    { 
        return [ 
            'ID', 
            'Nama Pelamar', 
            'Email', 
            'Job Title', 
            'Company', 
            'Status', 
            'Tanggal Lamar', 
        ]; 
    } 
     
    public function map($application): array 
    { 
        return [ 
            $application->id, 
            $application->user->name, 
            $application->user->email, 
            $application->job->title, 
            $application->job->company, 
            $application->status, 
            $application->created_at->format('d-m-Y H:i'), 
        ]; 
} 
}