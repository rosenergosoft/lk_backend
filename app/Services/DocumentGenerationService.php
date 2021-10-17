<?php
namespace App\Services;

use App\Models\Application;
use App\Models\CompanyInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentGenerationService {
    private $electricityPhysTemplateName = 'phys_el_app.docx';
    private $electricityYurTemplateName = 'yur_el_app.docx';

    /**
     * @param $companyInformation
     * @param $user
     * @param $application
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function generateElectricityDocs ($companyInformation, $user, $application) {

        if($user->company) {
            $templateProcessor = new TemplateProcessor(resource_path('docs/' . $this->electricityYurTemplateName));
            $templateProcessor->setValue('yur_name', $user->company->name);
            $templateProcessor->setValue('yur_inn', $user->company->inn);
            $templateProcessor->setValue('r_s', $user->company->check_account);
            $templateProcessor->setValue('yur_address', $user->company->address);
            $templateProcessor->setValue('bank_name', $user->company->bank_name);
            $templateProcessor->setValue('bank_bik', $user->company->bank_bik);
            $templateProcessor->setValue('korr_acc', $user->company->bank_corr_account);
        } else $templateProcessor = new TemplateProcessor(resource_path('docs/' . $this->electricityPhysTemplateName));

        $templateProcessor->setValue('company_name', CompanyInformation::getValue($companyInformation, 'name'));
        $templateProcessor->setValue('company_address', CompanyInformation::getValue($companyInformation, 'address'));
        $templateProcessor->setValue('company_phones', CompanyInformation::getValue($companyInformation, 'phone1'));
        $templateProcessor->setValue('company_email', CompanyInformation::getValue($companyInformation, 'email'));
        $templateProcessor->setValue('company_short_name', CompanyInformation::getValue($companyInformation, 'short_name'));
        $templateProcessor->setValue('application_number', Carbon::now()->format('d/m/Y-') . $application->id);
        $templateProcessor->setValue('application_date', Carbon::now()->format('d/m/Y'));
        $templateProcessor->setValue('fullname', $user->profile->first_name . ' ' . $user->profile->middle_name . ' ' . $user->profile->last_name);
        $templateProcessor->setValue('passport', $user->profile->pasport . ', ' . $user->profile->pasport_granted_by . ', ' . Carbon::parse($user->profile->pasport_date)->format('d.m.Y'));
        $templateProcessor->setValue('reg_address', $user->profile->reg_address);
        $templateProcessor->setValue('phys_address', $user->profile->phys_address ?? $user->profile->reg_address);
        if($application->connectionType == 0) {
            $connection = Application::$connectionType[intval($application->connectionType)];
        } else if ($application->connectionType == 1) {
            $connection = Application::$connectionType[intval($application->connectionType)] . ". Номер текущего договора: " . $application->contractNumber . ". Дата: " . Carbon::parse($application->contractDate)->format('d.m.Y');
        } else if ($application->connectionType == 2) {
            $connection = Application::$connectionType[intval($application->connectionType)] . ". Продолжительность подключения в днях: " . $application->connectionDuration;
        }
        $templateProcessor->setValue('connection_type', $connection);
        $templateProcessor->setValue('object_name', $application->objectName);
        $templateProcessor->setValue('object_location', $application->objectLocation);
        $templateProcessor->setValue('kadastr_num', $application->kadastrNum);
        $templateProcessor->setValue('construction_reason', Application::$constructionReason[intval($application->constructionReason)]);
        $templateProcessor->setValue('connectors_count', $application->connectorsCount);
        $templateProcessor->setValue('max_power', $application->maxPower);
        $templateProcessor->setValue('previous_max_power', $application->previousMaxPower);
        $templateProcessor->setValue('integrity_category', Application::$integrityCategory[intval($application->integrityCategory)]);
        $templateProcessor->setValue('power_level', Application::$powerLevel[intval($application->powerLevel)]);
        $templateProcessor->setValue('load_type', Application::$loadType[intval($application->loadType)]);
        $templateProcessor->setValue('emergency_auto', Application::$emergencyAuto[intval($application->emergencyAuto)]);
        $templateProcessor->setValue('estimation_quater', $application->estimationQuater);
        $templateProcessor->setValue('estimation_year', $application->estimationYear);
        $templateProcessor->setValue('power', $application->power);
        $templateProcessor->setValue('pricing', Application::$pricing[intval($application->pricing)]);
        if($application->vendor_id) {
            $vendor = 'Гарантирующий поставщик: ' . $application->vendor->name . '. ';
        } else $vendor = '';
        $templateProcessor->setValue('other', $vendor. $application->other);
        $templateProcessor->setValue('email', $user->email);
        $templateProcessor->setValue('phone', $user->phone);

        $filepath = $templateProcessor->save();
        if(!file_exists(storage_path('app/public/applications'))) {
            File::makeDirectory(storage_path('app/public/applications'), $mode = 0777, true, true);
        }

        File::move($filepath, storage_path('app/public/applications/electricity_application_' . $application->id . '.docx'));
        return [
            'path' => 'applications/electricity_application_' . $application->id . '.docx',
            'name' => 'Заявка на ТП (электричество)_' . $application->id . '.docx'
        ];
    }
}
