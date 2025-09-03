<?php

namespace App\Utilities;

//require_once 'vendor/autoload.php'; // Include Composer's autoloader

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Metadata\DocInfo;
use PhpOffice\PhpWord\IOFactory;
use Exception;

class Documents
{
    private array $sections = array();
    private int $countSection = 1;
    private string $nomefile = '';
    protected PhpWord $phpWord;

    function __construct($nomefile = null)
    {
        if (isset($nomefile)) {
            try {
                $objReader = IOFactory::createReader('Word2007');
                Settings::setZipClass(Settings::PCLZIP);
                $this->phpWord = $objReader->load($nomefile);
            } catch (Exception $e) {
                print_r($e->getCode() . ' -> ' . $e->getMessage());
            }
        }
    }


    function setProperties($creator = 'Michele Genchi', $title = 'PHPWord')
    {
        // Set document properties
        $properties = $this->phpWord->getDocInfo();
        $properties->setCreator($creator);
        //$properties->setCompany('File Format');
        $properties->setTitle($title);
        $properties->setDescription('File Format Developer Guide');
        $properties->setCreated(date("Y-m-d H:i:s"));
        $properties->setModified(date("Y-m-d H:i:s"));
        $properties->setSubject('PHPWord');
    }

    function settings()
    {
        Settings::setDefaultFontName('Arial');
        Settings::setDefaultFontSize(14);
    }

    function newSection()
    {
        // Create a new Section
        $sections[$this->countSection] = $this->phpWord->addSection();
        $this->countSection++;
    }

    function addText(int $count = 1, string $testo = 'prova')
    {
        // Add some text
        $this->sections[$count]->addText($testo);
    }

    private function getTextFromTextRun($element) {
        $text='';
            switch (get_class($element)) {
                case 'PhpOffice\PhpWord\Element\TextRun':
                    foreach ($element->getElements() as $e)
                    {
                        $text.= $this->getTextFromTextRun($e);
                    }
                    break;
                case 'PhpOffice\PhpWord\Element\Text':
                    $text.= (str_starts_with($element->getText(), '$_'))?$element->getText():'';
                    break;
                case 'PhpOffice\PhpWord\Element\TextBreak':
                    $text.='';
                default:
                    break;
            }
        return $text;
    }

    private function iterateOverRows($table) {
        $text='';
        $rows = $table->getRows();
        foreach ($rows as $row) {
            foreach ($row->getCells() as $cell) {
                $els = $cell->getElements();
                    foreach ($els as $e) {
                        $text.=$this->matched_element($e);
                    }
            }
        }
        return $text;
    }



    function matched_element($element): String 
    {
        $matched= match (get_class($element))
        {
            \PhpOffice\PhpWord\Element\TextRun::class => $this->getTextFromTextRun($element),
            \PhpOffice\PhpWord\Element\Table::class => $this->iterateOverRows($element),
            \PhpOffice\PhpWord\Element\TextBreak::class =>'',
            default => "ELemento word $element inesistente!"
        };
        return $matched.';';
    }
    
    function read(): string
    {
        $content = '';
        foreach ($this->phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $content.=$this->matched_element($element);
            }
        }
        return $content;
    }

    function scrivi()
    {
        $writer = IOFactory::createWriter($this->phpWord, 'Word2007'); // Or 'OOXML'
        $writer->save($this->nomefile);
    }
}


