<?php

class Images
{
    /**
     * @param $dataFile - данные добаляемого файла
     * @return string|string[]
     */
    public function uploadImg($dataFile)
    {
        // Данный метод проверит является ли файл картинкой, если нет то он просто будет пустой
        $file = getimagesize($dataFile['tmp_name']);

        if (!$file) {
            return ['ERROR' => 'Файл не является картинкой'];
        }

        // Вытаскиваем расширение картинки
        $exec = substr(strstr($file['mime'], '/'), 1);

        // Создаём уникальное название файла
        $fileName = uniqid() . '.' . $exec;

        // Путь для создания файла
        $path = "../images/$fileName";

        // Проверяем, загрузилась ли картинка
        if (move_uploaded_file($dataFile['tmp_name'], $path)){
            return $fileName;
        }else{
            return ['ERROR'=>'Ошибка загрузки картинки на сервер'];
        }

    }

}