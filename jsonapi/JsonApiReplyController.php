<?php

namespace Controller;

use Model;

class JsonApiReplyController
{
    private array $treeSlicesArr;
    private array $elemsGlossaryArr;
    private array $treeArr;
    private array $hierarchyArr;

    public function deleteElem($deleteArr)
    {
        try {
            $db = new Model\DB();
            $db->init();
            $db->query("DELETE FROM catalogue.objects WHERE title='" . urldecode($deleteArr[1]) . "'");

            foreach ($this->elemsGlossaryArr as $row) {
                if ($row[1] === urldecode($deleteArr[1])) {
                    $object = $row[0];
                }
            }

            $db = new Model\DB();
            $db->init();
            $db->query("DELETE FROM catalogue.hierarchy WHERE id=" . $object . " OR ancestor=" . $object);

        } catch (\Exception $e) {
            $error = new InputGetUrlDataErrorsController();
            $error->serviceWrongParameterInUrl();
        }
    }

    public function addElem($argumentsArr)
    {
        $db = new Model\DB();
        $db->init();
        $db->query("INSERT INTO catalogue.objects(title) VALUES ('" . urldecode($argumentsArr[1][1]) . "')");

        $this->getObjectsGlossary();
        foreach ($this->elemsGlossaryArr as $row) {
            if ($row[1] === urldecode($argumentsArr[1][1])) {
                $object = $row[0];
            }

            if ($row[1] === urldecode($argumentsArr[0][1])) {
                $parent = $row[0];
            }
        }

        if (empty($object) || empty($parent)) {
            $error = new InputGetUrlDataErrorsController();
            $error->serviceWrongParameterInUrl();
            exit;
        }

        $db = new Model\DB();
        $db->init();
        $db->query("INSERT INTO catalogue.hierarchy VALUES (" . $object . ", " . $parent . ")");
    }

    public function shiftElem($shiftArr)
    {
        try {
            $this->getObjectsGlossary();
            foreach ($this->elemsGlossaryArr as $row) {
                print_r($row);
                if ($row[1] === urldecode($shiftArr[1][1])) {
                    $object = $row[0];
                    print_r($object);
                }
                if ($row[1] === urldecode($shiftArr[0][1])) {
                    $parent = $row[0];
                }
            }

            $db = new Model\DB();
            $db->init();
            $db->query("UPDATE catalogue.hierarchy SET ancestor=" . $parent . " WHERE id=" . $object . "");
        } catch (\Exception $e) {
            $error = new InputGetUrlDataErrorsController();
            $error->serviceWrongParameterInUrl();
        }

    }


    public function getWholeCatalogue()
    {
        print_r(json_encode($this->renderWholeCatalogue(), JSON_UNESCAPED_UNICODE));
    }

    public function getPartNeeded($categoryName)
    {
        print_r($this->renderPartNeeded($categoryName));
    }

    public function renderPartNeeded($categoryName)
    {
        $cutCatalogue = [];
        $categoryName = urldecode($categoryName);
        $this->getHierarchyArr();

        $wholeCatalogue = $this->renderWholeCatalogue();

        while (!empty($wholeCatalogue)) {
            $keyArr = array_keys($wholeCatalogue);
            if (!in_array($categoryName, $keyArr)) {

                foreach ($keyArr as $number => $value) {
                    $cutCatalogue = array_merge($cutCatalogue, $wholeCatalogue[$value]);
                }
                $wholeCatalogue = $cutCatalogue;
            } else {
                return json_encode($wholeCatalogue[$categoryName], JSON_UNESCAPED_UNICODE);
            }
        }

        $error = new InputGetUrlDataErrorsController();
        $error->serviceWrongParameterInUrl();
    }

    private function getObjectsGlossary(): void
    {
        $dbRequestCat = new Model\DB();
        $dbRequestCat->init();
        $this->elemsGlossaryArr = $dbRequestCat->query('SELECT * FROM catalogue.objects');
    }

    private function getHierarchyArr(): void
    {
        $dbRequestObj = new Model\DB();
        $dbRequestObj->init();
        $this->hierarchyArr = $dbRequestObj->query('SELECT * FROM catalogue.hierarchy');
    }

    private function renderWholeCatalogue(): array
    {
        $this->getObjectsGlossary();
        $this->getHierarchyArr();

        $this->scanCatalogueLevels($this->hierarchyArr);
        return $this->developCatTree();
    }

    private function scanCatalogueLevels($hierarchyArr, $allObjectsIds = []): void
    {
        if (empty($allObjectsIds)) {
            foreach ($hierarchyArr as $oneCategoryPosition) {
                if ($oneCategoryPosition[1] !== null) {
                    continue;
                }
                $allObjectsIds[$oneCategoryPosition[0]] = array();
            }
        }

        if (empty($allObjectsIds)) {
            foreach ($hierarchyArr as $oneCategoryPosition2) {
                $objectsArr[] = $oneCategoryPosition2[0];
            }

            foreach ($hierarchyArr as $oneCategoryPosition2) {
                if (!in_array($oneCategoryPosition2[1], $objectsArr)) {
                    $allObjectsIds[$oneCategoryPosition2[0]] = array();
                }
            }
        }

        foreach ($allObjectsIds as $mainCategory => $emptyArray) {
            foreach ($hierarchyArr as $oneCategoryCharacteristics) {
                if ($oneCategoryCharacteristics[1] == $mainCategory) {
                    array_push($allObjectsIds[$mainCategory], $oneCategoryCharacteristics[0]);
                }
            }
        }

        $openNextTreeLevelArr = [];
        foreach ($allObjectsIds as $arrArr) {
            $openNextTreeLevelArr = array_merge($openNextTreeLevelArr, $arrArr);
        }

        $openNextTreeLevelArr = array_flip($openNextTreeLevelArr);

        foreach ($openNextTreeLevelArr as $obj => $content) {
            $deeperLevelArr[$obj] = array();
        }

        $this->treeSlicesArr[] = $allObjectsIds;
        $allObjectsIds = $deeperLevelArr;

        if (!empty($allObjectsIds)) {
            $this->scanCatalogueLevels($hierarchyArr, $allObjectsIds);
        }
    }

    private function developCatTree()
    {
        $treeArr = [];
        foreach ($this->treeSlicesArr[0] as $sliceArr => $oneSliceDetails) {
            $sliceArr = $this->changeIDsWithRealNames($sliceArr);
            $treeArr[$sliceArr] = [];
            foreach ($oneSliceDetails as $separateCategoryPosition) {
                $textInsteadOfNumberId2 = $this->changeIDsWithRealNames($separateCategoryPosition);
                $treeArr[$sliceArr][$textInsteadOfNumberId2] = $this->combineSlices($separateCategoryPosition, $this->treeSlicesArr);
            }
        }

        $this->treeArr = $treeArr;

        return $treeArr;
    }

    private function combineSlices($oneTreeElem, $treeSlicesArr, $next = 1)
    {
        $combinedTree = [];
        if ($treeSlicesArr[$next][$oneTreeElem]) {
            foreach ($treeSlicesArr[$next][$oneTreeElem] as $oneElem) {
                $textInsteadOfNumberId = $this->changeIDsWithRealNames($oneElem);
                $combinedTree[$textInsteadOfNumberId] = $this->combineSlices($oneElem, $treeSlicesArr, $next + 1);
            }
        }
        return $combinedTree;
    }

    private function changeIDsWithRealNames(string $inputKey)
    {
        foreach ($this->elemsGlossaryArr as $row) {
            if ($row[0] === $inputKey) {
                return $row[1];
            } elseif (is_string($inputKey)) {
                if ($row[0] === "$inputKey") {
                    return $row[1];
                }
            }
        }
    }
}