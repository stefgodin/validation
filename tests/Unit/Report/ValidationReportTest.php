<?php


namespace Report;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Report\ValidationError;
use Stefmachine\Validation\Report\ValidationReport;

class ValidationReportTest extends TestCase
{
    /** @test */
    public function Should_MergeErrorsAsIs_WhenMergingWithoutSubPath()
    {
        $report = new ValidationReport();
        $report->addError(new ValidationError('388d92fc-7f09-4962-9d20-94e010c5468c', 'ERROR_1', 'An error {no}', ['{no}' => 1], 'err1'))
            ->addError(new ValidationError('a7647211-40fb-4df0-9f09-f4cb1039d170', 'ERROR_2', 'An error {no}', ['{no}' => 2], '[2]'))
            ->addError(new ValidationError('ba99a52b-0d70-41f9-8522-7b3ebd1b1c8e', 'ERROR_3', 'An error {no}', ['{no}' => 3], ''));
        
        $otherReport = new ValidationReport();
        $otherReport->addError(new ValidationError('a9902de2-73f2-4e5c-acc7-16b7d3f3f01b', 'ERROR_4', 'An error {no}', ['{no}' => 4], 'err4'))
            ->addError(new ValidationError('c7fae6eb-e716-4f5a-801c-7927ca5e5437', 'ERROR_5', 'An error {no}', ['{no}' => 5], '[5]'))
            ->addError(new ValidationError('a4814b9c-391a-42dc-88ec-35632eb606cd', 'ERROR_6', 'An error {no}', ['{no}' => 6], ''));
        
        $report->merge($otherReport);
        
        $uuids = array_map(fn(ValidationError $err) => $err->getUuid(), $report->getErrors());
        $paths = array_map(fn(ValidationError $err) => $err->getPath(), $report->getErrors());
        $messages = array_map(fn(ValidationError $err) => $err->getMessage(), $report->getErrors());
        
        $this->assertEquals([
            '388d92fc-7f09-4962-9d20-94e010c5468c',
            'a7647211-40fb-4df0-9f09-f4cb1039d170',
            'ba99a52b-0d70-41f9-8522-7b3ebd1b1c8e',
            'a9902de2-73f2-4e5c-acc7-16b7d3f3f01b',
            'c7fae6eb-e716-4f5a-801c-7927ca5e5437',
            'a4814b9c-391a-42dc-88ec-35632eb606cd',
        ], $uuids);
        
        $this->assertEquals(['err1', '[2]', '', 'err4', '[5]', ''], $paths);
        $this->assertEquals(['An error 1', 'An error 2', 'An error 3', 'An error 4', 'An error 5', 'An error 6'], $messages);
    }
    
    /** @test */
    public function Should_MergeErrorsWithSubPath_WhenMergingWithStringSubPath()
    {
        $report = new ValidationReport();
        $report->addError(new ValidationError('388d92fc-7f09-4962-9d20-94e010c5468c', 'ERROR_1', 'An error {no}', ['{no}' => 1], 'err1'))
            ->addError(new ValidationError('a7647211-40fb-4df0-9f09-f4cb1039d170', 'ERROR_2', 'An error {no}', ['{no}' => 2], '[2]'))
            ->addError(new ValidationError('ba99a52b-0d70-41f9-8522-7b3ebd1b1c8e', 'ERROR_3', 'An error {no}', ['{no}' => 3], ''));
        
        $otherReport = new ValidationReport();
        $otherReport->addError(new ValidationError('a9902de2-73f2-4e5c-acc7-16b7d3f3f01b', 'ERROR_4', 'An error {no}', ['{no}' => 4], 'err4'))
            ->addError(new ValidationError('c7fae6eb-e716-4f5a-801c-7927ca5e5437', 'ERROR_5', 'An error {no}', ['{no}' => 5], '[5]'))
            ->addError(new ValidationError('a4814b9c-391a-42dc-88ec-35632eb606cd', 'ERROR_6', 'An error {no}', ['{no}' => 6], ''));
        
        $report->merge($otherReport, 'test');
        
        $uuids = array_map(fn(ValidationError $err) => $err->getUuid(), $report->getErrors());
        $paths = array_map(fn(ValidationError $err) => $err->getPath(), $report->getErrors());
        $messages = array_map(fn(ValidationError $err) => $err->getMessage(), $report->getErrors());
        
        $this->assertEquals([
            '388d92fc-7f09-4962-9d20-94e010c5468c',
            'a7647211-40fb-4df0-9f09-f4cb1039d170',
            'ba99a52b-0d70-41f9-8522-7b3ebd1b1c8e',
            'a9902de2-73f2-4e5c-acc7-16b7d3f3f01b',
            'c7fae6eb-e716-4f5a-801c-7927ca5e5437',
            'a4814b9c-391a-42dc-88ec-35632eb606cd',
        ], $uuids);
        
        $this->assertEquals(['err1', '[2]', '', 'test.err4', 'test[5]', 'test'], $paths);
        $this->assertEquals(['An error 1', 'An error 2', 'An error 3', 'An error 4', 'An error 5', 'An error 6'], $messages);
    }
    
    /** @test */
    public function Should_MergeErrorsWithSubPath_WhenMergingWithIntSubPath()
    {
        $report = new ValidationReport();
        $report->addError(new ValidationError('388d92fc-7f09-4962-9d20-94e010c5468c', 'ERROR_1', 'An error {no}', ['{no}' => 1], 'err1'))
            ->addError(new ValidationError('a7647211-40fb-4df0-9f09-f4cb1039d170', 'ERROR_2', 'An error {no}', ['{no}' => 2], '[2]'))
            ->addError(new ValidationError('ba99a52b-0d70-41f9-8522-7b3ebd1b1c8e', 'ERROR_3', 'An error {no}', ['{no}' => 3], ''));
        
        $otherReport = new ValidationReport();
        $otherReport->addError(new ValidationError('a9902de2-73f2-4e5c-acc7-16b7d3f3f01b', 'ERROR_4', 'An error {no}', ['{no}' => 4], 'err4'))
            ->addError(new ValidationError('c7fae6eb-e716-4f5a-801c-7927ca5e5437', 'ERROR_5', 'An error {no}', ['{no}' => 5], '[5]'))
            ->addError(new ValidationError('a4814b9c-391a-42dc-88ec-35632eb606cd', 'ERROR_6', 'An error {no}', ['{no}' => 6], ''));
        
        $report->merge($otherReport, 7);
        
        $uuids = array_map(fn(ValidationError $err) => $err->getUuid(), $report->getErrors());
        $paths = array_map(fn(ValidationError $err) => $err->getPath(), $report->getErrors());
        $messages = array_map(fn(ValidationError $err) => $err->getMessage(), $report->getErrors());
        
        $this->assertEquals([
            '388d92fc-7f09-4962-9d20-94e010c5468c',
            'a7647211-40fb-4df0-9f09-f4cb1039d170',
            'ba99a52b-0d70-41f9-8522-7b3ebd1b1c8e',
            'a9902de2-73f2-4e5c-acc7-16b7d3f3f01b',
            'c7fae6eb-e716-4f5a-801c-7927ca5e5437',
            'a4814b9c-391a-42dc-88ec-35632eb606cd',
        ], $uuids);
        
        $this->assertEquals(['err1', '[2]', '', '[7].err4', '[7][5]', '[7]'], $paths);
        $this->assertEquals(['An error 1', 'An error 2', 'An error 3', 'An error 4', 'An error 5', 'An error 6'], $messages);
    }
}