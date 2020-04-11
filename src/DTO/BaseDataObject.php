<?php

namespace SaveTime\AtolV4\DTO;

abstract class BaseDataObject
{
    /**
     * Получить параметры, сгенерированные командой
     * @return array
     */
    public function getParameters()
    {
        $fieldVars = [];
        foreach (get_object_vars($this) as $name => $value) {
            if ($value) {
                if ($value instanceof BaseDataObject) {
                    $fieldVars[$name] = $value->getParameters();
                } else {
                    $fieldVars[$name] = $value;
                }
            }
        }
        return $fieldVars;
    }
}
