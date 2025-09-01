<?php

namespace App\Utilities;

//require_once 'vendor/autoload.php'; // Include Composer's autoloader

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Metadata\DocInfo;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Style;
use Exception;

class Documents
{
    private array $sections = array();
    private int $countSection = 1;
    private string $nomefile = '';
    private DocInfo $properties;
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

    function matched_content($childElement): String 
    {
        $matched='';
        if (method_exists($childElement, 'getText')) 
            $matched=$childElement->getText();            
        else if (method_exists($childElement, 'getContent')) 
            $matched=$childElement->getContent();
        else if (method_exists($childElement, 'getTable')) 
            foreach ($childElement->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    $els = $cell->getElements();
                    foreach ($els as $e) 
                        $matched=$this->switchElements($e);
                }
            }
        else "ELemento word $childElement inesistente!";
        return $matched;
    }
    
    function read(): string
    {
        $content = '';
        foreach ($this->phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getElements')) {
                    foreach ($element->getElements() as $childElement) {
                        $content=self::matched_content($childElement);
                    }
                }
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


