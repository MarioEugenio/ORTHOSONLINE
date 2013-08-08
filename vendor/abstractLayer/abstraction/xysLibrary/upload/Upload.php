<?php
namespace abstraction\xysLibrary\upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Classe responsável por métodos de validação
 */
class Upload
{

    protected $filename;
    protected $dirname;
    protected $tmpdirname;
    protected $filetype;
    protected $file;

    /**
     *
     * @param array $file
     * @param string $dirname
     * @param array $filetype
     * @param string $tmpdirname
     */

    public function __construct ($file, array $filetype = NULL, $dirname, $tmpdirname)
    {
        $this->file       = $file;
        $this->dirname    = $dirname;
        $this->tmpdirname = $tmpdirname;
        $this->filetype   = $filetype;
        $this->checkFileType($this->filetype);
        $this->checkDir($this->dirname);
        $this->checkTmpDir($this->dirname);
    }

    /**
     * Realiza o upload do arquivo para m diretório temporário
     *
     * @param array $file
     *
     * @return boolean
     */
    public function uploadTmp ()
    {
        $this->filename = $this->generateFileName($this->file['name']);

        if (!move_uploaded_file($this->file['tmp_name'], $this->tmpdirname . '/' . $this->filename)) {
            return FALSE;
        }
        return $this->filename;
    }

    /**
     * Move o arquivo enviado para o diretorio oficial
     * @return boolean
     */
    public function moveFileDir ($tmp, $dir)
    {
        if (!move_uploaded_file($tmp, $dir)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Verifica se o tamanho do arquivo enviado é menor ou igual ao limite definido no php.ini
     *
     * @param array $file
     *
     * @return boolean
     */
    public function checkFileSize ()
    {
        if ($this->file['size'] > UploadedFile::getMaxFilesize()) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Troca o nome do arquivo para um nome único, concatenando com o time()-, dessa forma é fácil de recuperar
     * o nome original pois o mesmo não será alterado
     *
     * @param string $strName
     *
     * @return string
     */
    public function generateFileName ()
    {
        $this->file['name'] = str_replace(array('-', ' ', '!', '?', '#', '^', '@', '*', '%'), '_', $this->file['name']);
        return time() . '-' . $this->file['name'];
    }

    /**
     * Verifica se o diretório onde será armazenada a imagem está acessível
     * @return boolean
     */
    public function checkDir ()
    {
        if (!is_dir($this->dirname)) {
            if (!mkdir($this->dirname, 0777)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Verifica se o diretório onde será armazenada a imagem temporariamente está acessível
     * @return boolean
     */
    public function checkTmpDir ()
    {
        if (!is_dir($this->dirname)) {
            if (!mkdir($this->dirname, 0777)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Verifica se o tipo do arquivo enviado é válido
     * @return boolean
     */
    public function checkFileType ()
    {
        if (!in_array($this->file['type'], $this->filetype)) {
            return FALSE;
        }
        return TRUE;
    }
}