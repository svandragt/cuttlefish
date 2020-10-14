<?php

namespace Cuttlefish;

use Exception;
use Michelf\Markdown;
use RuntimeException;
use StdClass;
use Cuttlefish\MetadataReader;

class Model
{
    public $contents = [];
    public $model = [];
    public $name;

    public function __construct($records)
    {
        try {
            if (array_unique($this->model) !== $this->model) {
                throw new RuntimeException('Array values not unique for model');
            }
        } catch (RuntimeException $e) {
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
        $File = new File($record);
        $content_sections = preg_split('/\R\R\R/', trim(file_get_contents($File->path)), count($this->model));
        $fields     = array_keys($this->model);
        $transforms   = array_values($this->model);

        try {
            if (count($transforms) !== count($content_sections)) {
                  throw new Exception( sprintf(
                      'Model (%s) definition (%s) does not match number of content sections (%s) in file (%s).',
                      get_class($this),
                      count($transforms),
                      count($content_sections),
	                  $record
                  ));
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            exit();
        }

	    $Content = new StdClass();
	    $Content->link = Url::fromFile($File)->url_absolute;

        for ($i = 0, $len = count($this->model); $i < $len; $i++) {
	        $field           = $fields[ $i ];
            $Content->$field = $this->section( $content_sections[ $i ], $transforms[ $i ] );
        }

        return $Content;
    }

	/**
	 * @param string $text
	 * @param string $transform
	 *
	 * @return StdClass
	 */
    public function section(string $text, string $transform): StdClass
    {
        $Section = new StdClass();
        switch ($transform) {
            case 'metadatareader':
                $reader = new MetadataReader();
                $data = $reader->loadString($text);

                foreach ($data as $key => $value) {
                    $Section->$key = $value;
                }
                break;
            case 'markdown':
                $markdown    = Markdown::defaultTransform($text);
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
