<?php
namespace app;
/**
 * 预排序遍历树算法(modified preorder tree traversal algorithm)
 */
use think\Db;

class MPTTA
{
    public $options = [
        'table' => 'user',
        'pk' => 'id',
        'lft' => 'lft',
        'rgt' => 'rgt',
        'parent_id' => 'parent_id',
        'node_status' => 'node_status'
    ];

    /**
     * 添加节点
     * 我们选择在父节点尾部插入新节点
     * @param int $parent_node    父节点id
     * @param int $node_id        要插入的节点id
     */
    public function installNode($node_id, $parent_node_id)
    {
        $table = $this->options['table'];
        // 先取出父节点的信息
        if ($parent = Db::query("SELECT id,lft,rgt,parent_id,node_status FROM `user` WHERE `{$this->options['pk']}`=$parent_node_id")) {
            $parent = $parent[0];
        }
        // 再取出子节点的信息
        if ($node = Db::query("SELECT id,lft,rgt,parent_id,node_status FROM `user` WHERE `{$this->options['pk']}`=$node_id")) {
            $node = $node[0];
        }
        $num = $node[$this->options['rgt']] + 1 - $node[$this->options['lft']];
        //更新代理表 左右值
        Db::query("UPDATE `$table` SET `{$this->options['lft']}`=`{$this->options['lft']}`+$num WHERE `{$this->options['lft']}`>{$parent[$this->options['rgt']]} AND `{$this->options['node_status']}`=0");
        Db::query("UPDATE `$table` SET `{$this->options['rgt']}`=`{$this->options['rgt']}`+$num WHERE `{$this->options['rgt']}`>={$parent[$this->options['rgt']]} AND `{$this->options['node_status']}`=0");

        $num2 = $parent['rgt'] - $node[$this->options['lft']];
        //更新被转移的左右节点
        Db::query("UPDATE `$table` SET `{$this->options['lft']}`=`{$this->options['lft']}`+$num2, `{$this->options['rgt']}`=`{$this->options['rgt']}`+$num2, `{$this->options['node_status']}`=0 WHERE `{$this->options['lft']}`>={$node[$this->options['lft']]} AND `{$this->options['rgt']}`<={$node[$this->options['rgt']]} AND `{$this->options['node_status']}`=1");
        //更新 被转移的 上级
         Db::query("UPDATE `$table` SET `{$this->options['parent_id']}`=$parent_node_id WHERE `{$this->options['pk']}`=$node_id");
    
    }

    
    /**
     * 删除节点
     */
    public function removeNode($node_id)
    {
        $table = $this->options['table'];
        $pk = $this->options['pk'];
        $rgt = $this->options['rgt'];
        $lft = $this->options['lft'];
        // 取出子节点的信息
        if ($node = Db::query("SELECT id,lft,rgt,parent_id,node_status FROM `$table` WHERE `$pk`=$node_id")) {
            $node = $node[0];
        }

        $num = $node[$rgt] + 1 - $node[$lft];
        Db::query("UPDATE `$table` SET `{$this->options['node_status']}`=1 WHERE {$lft}>={$node[$lft]} AND {$rgt}<={$node[$rgt]}");//代理表 改变状态软删除
       
        // 代理表 大于 （删除的左右节点） 都 减去 $num
        Db::query("UPDATE `$table` SET `{$this->options['rgt']}`=`{$this->options['rgt']}`-$num WHERE {$this->options['rgt']}>{$node[$this->options['rgt']]} AND `{$this->options['node_status']}`=0");
        Db::query("UPDATE `$table` SET `{$this->options['lft']}`=`{$this->options['lft']}`-$num WHERE {$this->options['lft']}>{$node[$this->options['lft']]} AND `{$this->options['node_status']}`=0");
     
    }

    /**
     * 移动节点
     * @param int $parent_node_id  新加入父节点id
     * @param int $node_id  子节点id
     */
    public function moveNode($parent_node_id, $node_id)
    {
        $this->removeNode($node_id);
        $this->installNode($node_id, $parent_node_id);
        return 1;
    }
}