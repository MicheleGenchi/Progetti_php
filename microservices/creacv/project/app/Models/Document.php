<?php

namespace App\Models;

//require_once 'vendor/autoload.php'; // Include Composer's autoloader

use App\Traits\HandlerWordTrait;
use App\Traits\WithRestUtilsTrait;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Exception;


class Document
{
    use HandlerWordTrait,
        WithRestUtilsTrait;

    private array $sections = array();
    private int $countSection = 1;
    protected PhpWord $phpWord;

    function __construct(?String $nomefile = null)
    {
    
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

    function read($nomefile): Array
    {
        rename($nomefile ,$nomefile.'.docx');
        $nomefile.='.docx';
        if (isset($nomefile)) {
            try {
                $objReader = IOFactory::createReader('Word2007');
                Settings::setZipClass(Settings::PCLZIP);
                $this->phpWord = $objReader->load($nomefile);
            } catch (Exception $e) {
                return ['code' => $e->getCode(), 'errore' => $e->getMessage()];
            }
        }
        $content = '';
        foreach ($this->phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $content.=$this->matched_element($element).' ';
            }
        }
        //$content=preg_match('/^([0-9]+)$/', $content);
        return ['code' => self::HTTP_OK, 'testo' => $content];
    }

    function scrivi(String $nomefile, String $template, Object $words)
    {
        //rename($nomefile ,$nomefile.'.docx');
        $reader = IOFactory::createReader('Word2007');
        $objReader = $reader->load($nomefile);
        $templateProcessor = new TemplateProcessor( $objReader);
        foreach ($words->fields as $key => $word) {
            if ($word instanceof \StdClass) $word='';
            $templateProcessor->setValue($key, $word);
            //$template=str_replace('$_'.$key, $word, $template);
        }
        $fileout=public_path().'/uploads/elaborato.docx';
        $temporary_file_path=$templateProcessor->save();
        $phpWord = IOFactory::load($temporary_file_path, 'Word2007');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($fileout);
        return ['merge' => "OK"];
    }
}


