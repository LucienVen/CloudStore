<?php

namespace Core;

class DefException extends \Exception
{
    public static function handle(\Exception $e)
    {
        echo $e;
    }

    public function __toString()
    {
        return "<table>
                <tr>
                    <td>File: </td>
                    <td>".$this->getFile()."</td>
                </tr>
                <tr>
                    <td>Line: </td>
                    <td>".$this->getLine()."</td>
                </tr>
                <tr>
                    <td>Message: </td>
                    <td>".$this->getCode()." ".$this->getMessage()."</td>
                </tr>
                </table>
                <br>
                <code>".$this->getTraceAsString()."</code>";
    }
}
