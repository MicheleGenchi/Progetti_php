<?php

namespace App\Traits;

use Exception;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HeadingRenderer;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Type;
use SimpleXMLElement;
/**
 * Summary of ConstraintsTrait
 */
define("SYMBOLMATCH",'$_');
trait HandlerWordTrait
{
 

    private function elabora(string $text): string
    {
        $array = explode(' ', $text);
        $temptext = '';
        foreach ($array as $element) {
            $temptext = (str_starts_with($element, SYMBOLMATCH)) ? $element . ';' : '';
        }
        return $temptext;
    }

    public static function convertTextToArray(string $text): array
    {
        $array = [];
        $app=[];
        $temparray = explode(";", $text);
        foreach ($temparray as $element) {
            $element = substr($element, 2);
            if (!empty($element)) {
                $app=array_merge($app, [$element => '']);
                $array[0]=$app;
            }
        }
        return $array;
    }

    public static function array_to_xml($data, SimpleXMLElement &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $node=$xml_data->addChild("fields");//, htmlspecialchars("$key"));
                HandlerWordTrait::array_to_xml($value, $node);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    public static function scrivixml(array $data, $fileName)
    {
        // creating object of SimpleXMLElement
        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

        // function call to convert array to xml
        HandlerWordTrait::array_to_xml($data, $xml_data);

        //saving generated xml file; 
        $dom = dom_import_simplexml($xml_data)->ownerDocument;
        $dom->formatOutput = true;
        $dom->save($fileName);
        //$result = $xml_data->asXML($fileName);
    }

    private function getTextFromTextRun(object $element)
    {
        $text = '';
        switch (get_class($element)) {
            case 'PhpOffice\PhpWord\Element\TextRun':
                foreach ($element->getElements() as $e) {
                    $text .= $this->getTextFromTextRun($e);
                }
                break;
            case 'PhpOffice\PhpWord\Element\Text':
                $text .= $this->elabora($element->getText());
                break;
            case 'PhpOffice\PhpWord\Element\TextBreak':
                $text .= '';
            default:
                break;
        }
        return $text;
    }

    private function iterateOverRows(object $table)
    {
        $text = '';
        $rows = $table->getRows();
        foreach ($rows as $row) {
            foreach ($row->getCells() as $cell) {
                $els = $cell->getElements();
                foreach ($els as $e) {
                    $text .= $this->matched_element($e);
                }
            }
        }
        return $text;
    }

    function matched_element(object $element): string
    {
        $matched = match (get_class($element)) {
            \PhpOffice\PhpWord\Element\TextRun::class => $this->getTextFromTextRun($element),
            \PhpOffice\PhpWord\Element\Table::class => $this->iterateOverRows($element),
            \PhpOffice\PhpWord\Element\TextBreak::class => '',
            default => "ELemento word $element inesistente!"
        };
        return $matched;
    }
}
