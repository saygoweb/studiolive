<?php

require_once(dirname(__FILE__) . '/Config.php');

use lib\JsonRpcServer;

class StudioLiveAPI
{
	
	public function __construct()
	{
		// TODO put in the LF style error handler for logging / jsonrpc return formatting etc. CP 2013-07
		ini_set('display_errors', 0);
	}

	/**
	 * Create/Update a User
	 * @param ShowModel $json
	 * @return string Id of written object
	 */
	public function show_update($params) {
		$show = new \models\ShowModel();
		JsonRpcServer::decode($show, $params);
		$result = $show->write();
		return $result;
	}

	/**
	 * Read a show from the given $id
	 * @param string $id
	 */
	public function show_read($id) {
		$show = new \models\ShowModel($id);
		return $show;
	}
	
	/**
	 * Delete a show
	 * @param string $id
	 * @return string Id of deleted record
	 */
 	public function show_delete($id) {
 		$result = \models\ShowModel::remove($id);
		return $result;
 	}

	// TODO Pretty sure this is going to want some paging params
	public function show_list() {
		$list = new \models\ShowListModel();
		$list->read();
		return $list;
	}

}

function main() {
	$api = new StudioLiveAPI();
	JsonRpcServer::handle($api);
}

main();

?>