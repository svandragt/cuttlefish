<?php

namespace Cuttlefish;

use Exception;
use Michelf\Markdown;
use StdClass;
use Cuttlefish\MetadataReader;

class Model
{
    public $contents = [];
    public $model = [];

    public function __construct($records)
    {
        try {
            if (array_unique($this->model) !== $this->model) {
                throw new Exception('Array values not unique for model');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        $this->contents($records);
    }

    /**
     * @return void
     */
    public function contents($records)
    {
        // implement $this->contents in your controller
    }

    public function limit(int $max): self
    {
        $this->contents = array_slice($this->contents, 0, $max);

        return $this;
    }

    /**
     *
     * @return StdClass
     */
    protected function listContents($record): StdClass
    {
        $Content = new StdClass();

        $File = new File($record);

        $content_sections = preg_split('/\R\R\R/', trim(file_get_contents($File->path)), count($this->model));
        $section_keys     = array_keys($this->model);
        $section_values   = array_values($this->model);
        try {
            if (count($section_keys) != count($content_sections)) {
                  throw new Exception(
                      sprintf(
                          'Model (%s) definition (%s) does not match number of content sections (%s).',
                          get_class($this),
                          count($section_keys),
                          count($content_sections)
                      )
                  );
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            exit();
        }

        $Content->link = Url::fromFile($File)->url_absolute;

        for ($i = 0, $len = count($this->model); $i < $len; $i++) {
            $content_section         = $content_sections[ $i ];
            $section_key             = $section_keys[ $i ];
            $section_value           = $section_values[ $i ];
            $Content->$section_value = $this->section($content_section, $section_key);
        }

        return $Content;
    }

    /**
     * @param array-key $section_key
     *
     * @return StdClass
     */
    public function section(string $content_section, $section_key): StdClass
    {
        $Section = new StdClass();
        switch ($section_key) {
            case 'metadatareader':
                $reader = new MetadataReader();
                $data = $reader->loadString($content_section);

                foreach ($data as $key => $value) {
                    $Section->$key = $value;
                }
                break;
            case 'markdown':
                $markdown    = Markdown::defaultTransform($content_section);
                $sections = preg_split('/(\r\n|\n|\r)/', trim($markdown), 2);
                $Section->title = strip_tags(array_shift($sections));
                $Section->main = implode(PHP_EOL, $sections);
                break;

            default:
                break;
        }


        return $Section;
    }
}
