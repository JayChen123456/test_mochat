<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\RoomFission\Service;

use Hyperf\Database\Model\Builder;
use MoChat\Framework\Service\AbstractService;
use MoChat\Plugin\RoomFission\Contract\RoomFissionContactContract;
use MoChat\Plugin\RoomFission\Model\RoomFissionContact;

class RoomFissionContactService extends AbstractService implements RoomFissionContactContract
{
    /**
     * @var RoomFissionContact
     */
    protected $model;

    /**
     * 查询单条 - 根据ID.
     * @param int $id ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomFissionContactById(int $id, array $columns = ['*']): array
    {
        return $this->model->getOneById($id, $columns);
    }

    /**
     * 查询多条 - 根据ID.
     * @param array $ids ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomFissionContactsById(array $ids, array $columns = ['*']): array
    {
        return $this->model->getAllById($ids, $columns);
    }

    /**
     * 多条分页.
     * @param array $where 查询条件
     * @param array|string[] $columns 查询字段
     * @param array $options 可选项 ['orderByRaw'=> 'id asc', 'perPage' => 15, 'page' => null, 'pageName' => 'page']
     * @return array 分页结果 Hyperf\Paginator\Paginator::toArray
     */
    public function getRoomFissionContactList(array $where, array $columns = ['*'], array $options = []): array
    {
        return $this->model->getPageList($where, $columns, $options);
    }

    /**
     * 添加单条
     * @param array $data 添加的数据
     * @return int 自增ID
     */
    public function createRoomFissionContact(array $data): int
    {
        return $this->model->createOne($data);
    }

    /**
     * 添加多条
     * @param array $data 添加的数据
     * @return bool 执行结果
     */
    public function createRoomFissionContacts(array $data): bool
    {
        return $this->model->createAll($data);
    }

    /**
     * 修改单条 - 根据ID.
     * @param int $id id
     * @param array $data 修改数据
     * @return int 修改条数
     */
    public function updateRoomFissionContactById(int $id, array $data): int
    {
        return $this->model->updateOneById($id, $data);
    }

    /**
     * 删除 - 单条
     * @param int $id 删除ID
     * @return int 删除条数
     */
    public function deleteRoomFissionContact(int $id): int
    {
        return $this->model->deleteOne($id);
    }

    /**
     * 删除 - 多条
     * @param array $ids 删除ID
     * @return int 删除条数
     */
    public function deleteRoomFissionContacts(array $ids): int
    {
        return $this->model->deleteAll($ids);
    }

    /**
     * 查询.
     */
    public function getRoomFissionContactByCorpId(int $CorpId, array $columns = ['*']): array
    {
        $res = $this->model::query()
            ->where('corp_id', $CorpId)
            ->get($columns);

        $res || $res = collect([]);

        return $res->toArray();
    }

    /**
     * 查询多条
     * @param array|string[] $columns
     */
    public function getRoomFissionContactByCorpIdStatus(array $corpIds, int $status, array $columns = ['*']): array
    {
        $res = $this->model::query()
            ->whereIn('corp_id', $corpIds)
            ->where('status', $status)
            ->get($columns);

        $res || $res = collect([]);

        return $res->toArray();
    }

    /**
     * 查询客户信息-unionId&fissionId.
     * @param array|string[] $columns
     */
    public function getRoomFissionContactByRoomIdUnionIdFissionID(int $roomId, string $unionId, int $fissionId = 0, array $columns = ['*']): array
    {
        $res = $this->model::query()
            ->where('room_id', $roomId)
            ->when($fissionId > 0, function (Builder $query) use ($fissionId) {
                return $query->where('fission_id', $fissionId);
            })
            ->where('union_id', $unionId)
            ->first($columns);

        if (empty($res)) {
            return [];
        }

        return $res->toArray();
    }

    /**
     * 查询客户信息-unionId&fissionId.
     * @param array|string[] $columns
     */
    public function getRoomFissionContactByUnionIdFissionID(string $unionId, int $fissionId = 0, array $columns = ['*']): array
    {
        $res = $this->model::query()
            ->where('union_id', $unionId)
            ->when($fissionId > 0, function (Builder $query) use ($fissionId) {
                return $query->where('fission_id', $fissionId);
            })
            ->first($columns);

        if (empty($res)) {
            return [];
        }

        return $res->toArray();
    }

    /**
     * 获取客户助力好友.
     */
    public function getRoomFissionContactByParentUnionId(string $unionId, int $join_status, int $is_new, int $loss, array $columns = ['*']): array
    {
        $res = $this->model::query()
            ->where('parent_union_id', $unionId)
            ->when($join_status < 2, function (Builder $query) use ($join_status) {
                return $query->where('join_status', $join_status);
            })
            ->when($is_new < 2, function (Builder $query) use ($is_new) {
                return $query->where('is_new', $is_new);
            })
            ->when($loss < 2, function (Builder $query) use ($loss) {
                return $query->where('loss', $loss);
            })
            ->get($columns);

        if (empty($res)) {
            return [];
        }

        return $res->toArray();
    }

    /**
     * 统计
     */
    public function countRoomFissionContactByFissionID(int $fissionId, int $join_status, int $status, int $loss, int $roomId, string $day = ''): int
    {
        return $this->model::query()
            ->where('fission_id', $fissionId)
            ->when($join_status < 2, function (Builder $query) use ($join_status) {
                return $query->where('join_status', $join_status);
            })
            ->when($status < 2, function (Builder $query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($loss < 2, function (Builder $query) use ($loss) {
                return $query->where('loss', $loss);
            })
            ->when($roomId > 0, function (Builder $query) use ($roomId) {
                return $query->where('room_id', $roomId);
            })
            ->when(! empty($day), function (Builder $query) use ($day) {
                return $query->where('created_at', '>', $day);
            })
            ->count('id');
    }
}
