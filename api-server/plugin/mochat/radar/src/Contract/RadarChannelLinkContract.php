<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\Radar\Contract;

interface RadarChannelLinkContract
{
    /**
     * 查询单条 - 根据ID.
     * @param int $id ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRadarChannelLinkById(int $id, array $columns = ['*']): array;

    /**
     * 查询多条 - 根据ID.
     * @param array $ids ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRadarChannelLinksById(array $ids, array $columns = ['*']): array;

    /**
     * 多条分页.
     * @param array $where 查询条件
     * @param array|string[] $columns 查询字段
     * @param array $options 可选项 ['orderByRaw'=> 'id asc', 'perPage' => 15, 'page' => null, 'pageName' => 'page']
     * @return array 分页结果 Hyperf\Paginator\Paginator::toArray
     */
    public function getRadarChannelLinkList(array $where, array $columns = ['*'], array $options = []): array;

    /**
     * 添加单条
     * @param array $data 添加的数据
     * @return int 自增ID
     */
    public function createRadarChannelLink(array $data): int;

    /**
     * 添加多条
     * @param array $data 添加的数据
     * @return bool 执行结果
     */
    public function createRadarChannelLinks(array $data): bool;

    /**
     * 修改单条 - 根据ID.
     * @param int $id id
     * @param array $data 修改数据
     * @return int 修改条数
     */
    public function updateRadarChannelLinkById(int $id, array $data): int;

    /**
     * 删除 - 单条
     * @param int $id 删除ID
     * @return int 删除条数
     */
    public function deleteRadarChannelLink(int $id): int;

    /**
     * 删除 - 多条
     * @param array $ids 删除ID
     * @return int 删除条数
     */
    public function deleteRadarChannelLinks(array $ids): int;

    /**
     * 查询.
     */
    public function getRadarChannelLinkByCorpId(int $CorpId, array $columns = ['*']): array;

    /**
     * 获取多条
     * @param array|string[] $columns
     */
    public function getRadarChannelLinkByCorpIdRadarIdChannelId(int $corpId, int $radarId, int $channelId, array $columns = ['*']): array;

    /**
     * 获取多条
     * @param array|string[] $columns
     */
    public function getRadarChannelLinkByCorpIdRadarId(int $corpId, int $radarId, array $columns = ['*']): array;

    /**
     * 获取一条
     * @param array|string[] $columns
     */
    public function getRadarChannelLinkByCorpIdRadarIdChannelIdEmployeeId(int $corpId, int $radarId, int $channelId, int $employeeId, array $columns = ['*']): array;

    /**
     * 获取总点击人数.
     */
    public function countRadarChannelLinkByCorpIdRadarId(int $corpId, int $radarId, string $columns = ''): int;

    /**
     * 获取雷达渠道.
     * @param array|string[] $columns
     */
    public function getRadarChannelLinksByRadarId(int $radarId, array $columns = ['*']): array;
}
