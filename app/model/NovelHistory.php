<?php
namespace Model;

use Iam\Db;

class NovelHistory extends Common
{
    public static function save($user_id, $novel_id, $chapter_id)
    {
        if (!$user_id) {
            return;
        }
        if (DB::table('novel_history')->where([
            'user_id' => $user_id,
            'novel_id' => $novel_id
        ])->find()) {
            DB::table('novel_history')->where([
                'user_id' => $user_id,
                'novel_id' => $novel_id
            ])->update([
                'chapter_id' => $chapter_id,
                'update_time' => now()
            ]);
        } else {
            $count = DB::table('novel_history')->field('COUNT(1) as count')->where(['user_id' => $user_id])->find()['count'];
            if ($count >= 20) {
                $last = DB::table('novel_history')->where([
                    'user_id' => $user_id
                ])->order('update_time ASC')->find();
                
                DB::table('novel_history')->where([
                    'id' => $last['id']
                ])->update([
                    'novel_id' => $novel_id,
                    'chapter_id' => $chapter_id,
                    'update_time' => now()
                ]);
            } else {
                DB::table('novel_history')->add([
                    'user_id' => $user_id,
                    'novel_id' => $novel_id,
                    'chapter_id' => $chapter_id,
                    'update_time' => now()
                ]);
            }
        }
    }

    public static function getList($user_id)
    {
        $list = [];
        if ($history = Db::table('novel_history')->where(['user_id' => $user_id])->select()){
            foreach ($history as $value) {
                $novel = Db::table('novel')->find('id',$value['novel_id']);
                $novel['mark'] = NovelMark::getTitle($novel['id']);
                $novel['chapter'] = Db::table('novel_chapter')->field(['title', 'id'])->find($value['chapter_id']);
                $list[] = $novel;
            }
        }
        return $list;
    }
}
