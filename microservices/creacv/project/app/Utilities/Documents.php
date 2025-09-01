<?php

namespace App\Utilities;

//require_once 'vendor/autoload.php'; // Include Composer's autoloader

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Metadata\DocInfo;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use Exception;

class Documents 
{
    private array $sections = array();
    private int $countSection = 1;
    private String $nomefile='';
    private DocInfo $properties;
    private PhpWord $phpWord;

    function __construct($nomefile = null)
    {
        if (isset($nomefile)) {
            try {
                $objReader= IOFactory::createReader('Word2007');
                Settings::setZipClass(Settings::PCLZIP);
                $this->phpWord= $objReader->load($nomefile);
            } catch (Exception $e) {
                print_r($e->getCode().' -> '.$e->getMessage());
            }
        }
    }


    function setProperties($creator = 'Michele Genchi', $title = 'PHPWord') {
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

    function read(): string
    {
        $text = '';
        foreach ($this->phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof $text) {
                    $text .= $element->getText();
                }
                // and so on for other element types (see src/PhpWord/Element)
            }
        }
        return $text;
    }

    function scrivi()
    {
        $writer = IOFactory::createWriter($this->phpWord, 'Word2007'); // Or 'OOXML'
        $writer->save($this->nomefile);
    }
}


