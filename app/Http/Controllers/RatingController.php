<?php


namespace App\Http\Controllers;


use App\Extensions\DataProviders\FormatterResponse;
use App\Extensions\DataProviders\Providers\ArrayDataProvider;
use App\Models\Ar\RatingType;
use App\Models\Ar\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function getRatingTypes(Request $request)
    {
        $data = RatingType::query()
            ->select(['name', 'slug'])
            ->orderBy('ord')
            ->get();

        $arrayDataProvider = new ArrayDataProvider($data->toArray());

        return response()->json(FormatterResponse::format($arrayDataProvider));
    }

    public function getRatingAll()
    {
        $sql = <<<SQL
with sort as (
    select t.id, t.name, sum(r.mark) as res from teams t
       inner join rating r on t.id = r.team_id
       inner join rating_types rt on rt.id = r.rating_type_id
    group by t.id, t.name
    order by res desc
)

select s.name, r.mark, rt2.name as rating_type from sort s
inner join rating r on r.team_id = s.id
inner join rating_types rt2 on rt2.id = r.rating_type_id
order by res, rt2.ord
SQL;

        $rawData = DB::select($sql);

        $prepareData = [];
        foreach ($rawData as $item) {
            $prepareData[$item->name][] = [
                'name' => $item->mark,
                'mark' => $item->rating_type
            ];
        }

        $data = [];
        foreach ($prepareData as $key => $item) {
            $data[] = [
                'team' => $key,
                'rating' => $item
            ];
        }

        $arrayDataProvider = new ArrayDataProvider($data);

        return response()->json(FormatterResponse::format($arrayDataProvider));
    }
}
