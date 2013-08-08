<?php

namespace abstraction\xysLibrary\helpers;

/**
 * Classe que organiza informações para gerar gráficos
 * Baseado na Implementação do HighCharts.js
 *
 * @author Eder Lamar <eder.mariano@xys.com.br>
 */
class Chart
{
    /**
     * Constantes que definem o tipo do dado no gráfico
     * line, spline, area, areaspline, column, bar, pie and scatter.
     */

    const LINE = 'line';
    const SPLINE = 'spline';
    const AREA = 'area';
    const AREAspline = 'areaspline';
    const COLUMN = 'column';
    const BAR = 'bar';
    const PIE = 'pie';
    const SCATTER = 'scatter';

    /**
     * Constantes de tipo de gráfico
     */
    const TYPE_JSON = 'json';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';

    /**
     * Informações necessárias para geração do gráfico
     * @var \stdClass
     */
    private $_data;

    /**
     * @var String
     */
    private $_type;

    public function __construct ($type = NULL)
    {
        $this->_data = new \stdClass();
        $this->_data->credits = new \stdClass();
        $this->_data->chart = new \stdClass();
        $this->_data->credits->enabled = FALSE;

        $this->_data->navigation = new \stdClass();
        $this->_data->navigation->buttonOptions = new \stdClass();
        $this->_data->navigation->buttonOptions->enabled = FALSE;
        $this->setTypeChart($type);
    }

    /**
     * Retorna uma estrutura pronta para o HighCharts gerar um gráfico
     * @param string $renderTo id da DIV onde será renderizado o gráfico
     * @param string $typeRender Tipo de gráfico (constante Chart::TYPE_*)
     * @return \stdClass
     */
    public function render ($renderTo, $typeRender = Chart::TYPE_JSON)
    {
        $this->_data->chart->renderTo = $renderTo;
        switch ($typeRender) {
            case Chart::TYPE_JSON:
                return \json_encode($this->_data);
            case Chart::TYPE_OBJECT:
                return $this->_data;
            case Chart::TYPE_ARRAY:
                return $this->toArray();
        }
        return $this->_data;
    }

    /**
     * Método que seta o zoom com o tipo desejado
     * @param string $type
     * @return Chart
     */
    public function setZoom ($type = "xy")
    {
        $this->_data->chart->zoomType = $type;
        return $this;
    }

    /**
     * Método que seta o título do gráfico
     * @param string $title
     * @return Chart
     */
    public function setTitle ($title)
    {
        $this->_data->title = new \stdClass();
        $this->_data->title->text = $title;
        return $this;
    }

    /**
     * Método que seta o subtítulo do gráfico
     * @param string $subTitle
     * @return Chart
     */
    public function setSubTitle ($subTitle)
    {
        $this->_data->subtitle = new \stdClass();
        $this->_data->subtitle->text = $subTitle;
        return $this;
    }

    /**
     * Método que seta o tipo de gráfico
     * @param string $type
     * @return Chart
     */
    public function setTypeChart ($type = Chart::SPLINE)
    {
        $this->_type = $type;
        $this->_data->chart->type = $type;
        return $this;
    }

    /**
     * Método que cria uma série de dados e seta o nome caso exista
     * @param array $data
     * @param string $label
     * @param string $type utilize as constantes de tipo de gráfico
     * @return Chart
     */
    public function addData (array $data, $label = null, $type = null)
    {
        $serie = new \stdClass();
        if ($label) {
            $serie->name = $label;
        }
        if ($type) {
            $serie->type = $type;
        }

        if ($this->_type == Chart::PIE) {
            $arData = array();
            foreach ($data as $label => $percent) {
                $arData[] = array($label, $percent);
            }

            $serie->type = Chart::PIE;
            $serie->data = $arData;
        } else {
            $serie->data = $data;
        }
        $this->_data->series[] = $serie;
        return $this;
    }

    /**
     *
     */
    public function addPlotOptions(){
        if($this->_type == Chart::PIE){
            $this->_data->plotOptions = new \stdClass();
            $this->_data->plotOptions->pie = new \stdClass();
            $this->_data->plotOptions->pie->allowPointSelect = TRUE;
            $this->_data->plotOptions->pie->cursor = 'pointer';
            $this->_data->plotOptions->pie->dataLabels = new \stdClass();
            //$this->_data->plotOptions->pie->dataLabels->enabled = FALSE;
            //$this->_data->plotOptions->pie->showInLegend = TRUE;
        }

        return $this;
    }

    /**
     * Método que seta as categorias do eixo Y
     * @param array $categories
     * @param string $title título para este dado em questão
     * @return Chart
     */
    public function setXaxis (array $categories = null, $title = null)
    {
        $this->_data->xAxis = new \stdClass();
        if (!empty($categories)) {
            $this->_data->xAxis->categories = $categories;
        }
        if ($title) {
            $this->_data->xAxis->title = $title;
        }
        return $this;
    }

    /**
     * Método que seta para o eixo Y um label
     * @return Chart
     */
    public function setYaxis ($title)
    {
        $this->_data->yAxis = new \stdClass();
        $this->_data->yAxis->title = new \stdClass();
        $this->_data->yAxis->title->text = $title;
        return $this;
    }

    /**
     * Alterna a visibilidade da legenda no gráfico.
     * @param boolean $enabled
     */
    public function setLegendEnabled ($enabled)
    {
        if (!isset($this->_data->legend)) {
            $this->_data->legend = new \stdClass();
        }
        $this->_data->legend->enabled = (boolean) $enabled;
    }

    /**
     * Método que pega o objeto stdClass e de forma recursiva o transforma em
     *  um array.
     * @return array
     */
    public function toArray ()
    {
        if (is_object($this->_data)) {
            $this->_data = get_object_vars($this->_data);
        }

        if (is_array($this->_data)) {
            return array_map(__FUNCTION__, $this->_data);
        } else {
            return $this->_data;
        }
    }

    /**
     * Método para ativar a exportação do gráfico
     * @param String $fileName
     * @return Chart;
     */
    public function exporting ($fileName = 'grafico')
    {
        $this->_data->navigation = new \stdClass();
        $this->_data->navigation->buttonOptions = new \stdClass();

        if ($fileName) {
            $this->_data->navigation->buttonOptions->enabled = TRUE;
            $this->_data->exporting = new \stdClass();
            $this->_data->exporting->filename = $fileName;
        } else {
            $this->_data->navigation->buttonOptions->enabled = FALSE;
        }
        return $this->_data;
    }

}

?>