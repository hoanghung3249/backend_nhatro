<?php

namespace Modules\Motel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Motel\Entities\Motel;
use Modules\Motel\Http\Requests\CreateMotelRequest;
use Modules\Motel\Http\Requests\UpdateMotelRequest;
use Modules\Motel\Repositories\MotelRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MotelController extends AdminBaseController
{
    /**
     * @var MotelRepository
     */
    private $motel;

    public function __construct(MotelRepository $motel)
    {
        parent::__construct();

        $this->motel = $motel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$motels = $this->motel->all();

        return view('motel::admin.motels.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('motel::admin.motels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMotelRequest $request
     * @return Response
     */
    public function store(CreateMotelRequest $request)
    {
        $this->motel->create($request->all());

        return redirect()->route('admin.motel.motel.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('motel::motels.title.motels')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Motel $motel
     * @return Response
     */
    public function edit(Motel $motel)
    {
        return view('motel::admin.motels.edit', compact('motel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Motel $motel
     * @param  UpdateMotelRequest $request
     * @return Response
     */
    public function update(Motel $motel, UpdateMotelRequest $request)
    {
        $this->motel->update($motel, $request->all());

        return redirect()->route('admin.motel.motel.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('motel::motels.title.motels')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Motel $motel
     * @return Response
     */
    public function destroy(Motel $motel)
    {
        $this->motel->destroy($motel);

        return redirect()->route('admin.motel.motel.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('motel::motels.title.motels')]));
    }
}
