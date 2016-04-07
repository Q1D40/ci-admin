<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="index.php?/excpt/version_excpt_list/" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>

				<td>
					时间：<input name="startDate" type="text" class="date" readonly="true" value="<?php echo $startDate;?>"/> 到 <input name="endDate" type="text" class="date" readonly="true" value="<?php echo $endDate;?>" />
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">

	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th>崩溃主程序版本</th>
				<th>崩溃占比</th>
			</tr>
		</thead>
		<tbody>

        <?php foreach($versionExcptList as $versionExcpt):?>
			<tr target="sid_user" rel="1">
				<td><a href="index.php?/excpt/ie_version_excpt_list/<?php echo $versionExcpt['version'];?>" target="navTab" rel="<?php echo $versionExcpt['version'];?>" fresh="true"><?php echo $versionExcpt['version'];?></a></td>
				<td><?php echo $versionExcpt['versionExcptProportion'] . '%';?></td>
			</tr>
        <?php endforeach;?>

		</tbody>
	</table>
</div>
