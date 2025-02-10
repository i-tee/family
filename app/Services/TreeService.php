<?php

namespace App\Services;

class TreeService
{
    public function calculateCoordinates(array $persons, int $centralId): array
    {
        // Преобразуем массив в ассоциативный массив для быстрого доступа по ID
        $peopleById = [];
        foreach ($persons as &$person) {
            $peopleById[$person['id']] = &$person;
        }

        // Инициализируем карту поколений
        $generationMap = [];

        // Найдём центральную персону и установим ей y = 0 и x = 0
        if (isset($peopleById[$centralId])) {
            $peopleById[$centralId]['y'] = 0;
            $peopleById[$centralId]['x'] = 0;

            // Обработка родителей
            $this->processParents($peopleById, $peopleById[$centralId], $generationMap);

            // Обработка детей
            $this->processChildren($peopleById, $peopleById[$centralId], $generationMap);
        }

        // Возвращаем обновленный массив персон
        return array_values($peopleById); // Преобразуем обратно в индексированный массив
    }

    protected function getNextXForY(&$generationMap, $y)
    {
        if (!isset($generationMap[$y])) {
            $generationMap[$y] = 0; // Первый представитель в этом поколении
        } else {
            $generationMap[$y]++; // Увеличиваем счетчик для этого поколения
        }
        return $generationMap[$y];
    }

    protected function processParents(&$peopleById, &$person, &$generationMap)
    {
        if ($person['mother_id'] !== null && isset($peopleById[$person['mother_id']])) {
            $mother = &$peopleById[$person['mother_id']];
            if (!isset($mother['y'])) {
                $mother['y'] = $person['y'] + 1;
                $mother['x'] = $this->getNextXForY($generationMap, $mother['y']);
                $this->processParents($peopleById, $mother, $generationMap);
            }
        }

        if ($person['father_id'] !== null && isset($peopleById[$person['father_id']])) {
            $father = &$peopleById[$person['father_id']];
            if (!isset($father['y'])) {
                $father['y'] = $person['y'] + 1;
                $father['x'] = $this->getNextXForY($generationMap, $father['y']);
                $this->processParents($peopleById, $father, $generationMap);
            }
        }
    }

    protected function processChildren(&$peopleById, &$person, &$generationMap)
    {
        foreach ($peopleById as &$child) {
            if (($child['mother_id'] == $person['id'] || $child['father_id'] == $person['id']) && !isset($child['y'])) {
                $child['y'] = $person['y'] - 1;
                $child['x'] = $this->getNextXForY($generationMap, $child['y']);
                $this->processChildren($peopleById, $child, $generationMap);
            }
        }
    }
}