<?php
/**
 * RecycleRecordBehavior.php
 * @author kohei hieda
 *
 */
class RecycleRecordBehavior extends ModelBehavior {

	function rewriteSaveArray($model, $dataArray, $conditions = array(), $cascade = false) {
		$existsIdList = array_keys($model->find('list', array('conditions'=>$conditions)));

		foreach ($dataArray as $data) {
			$model->create();
			if ($existsIdList) {
				$model->id = array_shift($existsIdList);
			}
			if (!$model->save($data)) {
				return false;
			}
		}

		if ($existsIdList) {
			foreach ($existsIdList as $existsId) {
				$model->delete($existsId, $cascade);
			}
		}

		return true;
	}

}