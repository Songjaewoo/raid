<?php
class Paging_info {
	
	public function getPagingInfo($curPage, $totalCount, $pageSize, $listSize) {
		$currentUrl= CURRENT_URL;
		$nextPage = 0;
		$prevPage = 0;
		$startPage = 1;
		$endPage = 1;
		
		$totalPage = ceil($totalCount / $pageSize);
		if ($totalPage == 0) {
			$endPage = 1;
			$totalPage = 1;
		}
		
		if ($curPage > $totalPage) {
			$curPage = $totalPage;
		}
		
		$startPage = ((ceil($curPage / $listSize) - 1) * $listSize) + 1;
		$endPage = $startPage + $listSize - 1;
		
		if ($endPage > $totalPage) {
			$endPage = $totalPage;
		}
		if ($startPage > 1) {
			$prevPage = $startPage - $listSize;
		}
		if ($endPage < $totalPage) {
			$nextPage = $endPage + 1;
		}
		
		$pageDelQueryString = $this->del_get_url($currentUrl, "pageNum");
		
		$pagination = array(
			'prevPage' => $prevPage,
			'nextPage' => $nextPage,
			'startPage' => $startPage,
			'endPage' => $endPage,
			'curPage' => $curPage,
			'totalPage' => $totalPage,
			'pageDelQueryString' => $pageDelQueryString,
		);
		
		return $pagination;
	}
	
	private function del_get_url($url, $key) {
		list ( $url, $query ) = explode ( '?', $url );
		$temp = explode ( '&', $query );
		foreach ( $temp as $k => $v ) {
			if (substr ( $v, 0, strlen ( $key ) + 1 ) == $key . '=') {
				unset ( $temp [$k] );
			}
		}
		return implode ( '&', $temp );
	}
}