<?php
namespace Joesama\Project\Http\Services;

use Joesama\VueGrid\Services\Grid;
use Illuminate\Pagination\LengthAwarePaginator;
/**
 * Generate Data Grid Using Vuegrid
 */
class DataGridGenerator 
{
	private $datagrid, $tableId;

	function __construct()
	{
		$this->datagrid = new Grid();
	}


	/**
	 * Build Data Table
	 * @param  array $columns
	 * @param  string $tableTitle
	 * @return [type]
	 */
	public function buildTable(array $columns, string $tableTitle)
	{
		// Set tabel title 
		$this->datagrid->setTitle($tableTitle);
		// Set the header & column field  
		$this->datagrid->setColumns($columns);

		return $this;
	}

	/**
	 * @param  string Path to navigate
	 * @param  string Button text value
	 * @return [type]
	 */
	public function buildAddButton(string $path, string $buttonText = NULL)
	{
		// add button link
		$this->datagrid->add( $path , $buttonText);

		return $this;
	}

	/**
	 * Build Extra Button
	 * 
	 * @param  array  $button Button Path & Description
	 * @return void
	 */
	public function buildExtraButton(array $buttons)
	{
		// add button link
		$this->datagrid->extraButton( $buttons );

		return $this;
	}

	/**
	 * @param  string $dataApi url path to sources data for ajax query
	 * @param  Illuminate\Pagination\LengthAwarePaginator  $model 
	 * @return void
	 */
	public function buildDataModel(string $dataApi , LengthAwarePaginator $model = NULL)
	{
		// Set Data API URL
		// $this->datagrid->apiUrl($dataApi);
		// Preload data when page load : optional
		if(!is_null($model)){
			$this->datagrid->setModel($model);
		}

		return $this;
	}


	/**
	 * @param  array $dataActions list of action
	 * @param  boolean $autoFilter true if required auto filtering
	 * @return [type]
	 */
	public function buildOption( array $dataActions, $autoFilter = FALSE)
	{	
		// Display Search Input : optional
		$this->datagrid->autoFilter($autoFilter);
		// Display Search Input : optional
		$this->datagrid->showSearch(false);
		// define action taken for each row of data
		// Second parameter if false use text representation
		$this->datagrid->action($dataActions,TRUE);

		return $this;
	}

	/**
	 * @return HTML Snippet
	 */
	public function render()
	{
		$data = $this->datagrid->build();

		return view('joesama/project::vuegrid.vuegrid',compact('data'));
	}

} // END class DataGridGenerator 