<?php

namespace App\Http\Controllers;

use App\Repositories\DreamRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DreamController extends Controller
{
    /**
     * Repository instance.
     *
     */
    protected $dreamRepository;

    /**
     * Validation rules.
     *
     */
    protected $rules = [
        'content' => 'required|max:2000',
    ];

    /**
     * Create a new DreamController controller instance.
     *
     * @param DreamRepository|\App\Repositories\DreamRepository $dreamRepository
     */
    public function __construct(DreamRepository $dreamRepository)
    {
        $this->dreamRepository = $dreamRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        return $this->dreamRepository->getDreamsWithUserPaginate(5, $search);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $this->dreamRepository->store($request->all(), Authorizer::getResourceOwnerId());
        return $this->dreamRepository->getDreamsWithUserPaginate(5);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return ['data' => $this->dreamRepository->getById($id)];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        if ($this->dreamRepository->update($request->all(), $id))
        {
            return ['result' => 'success'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->dreamRepository->destroy($id))
        {
            return ['result' => 'success'];
        }

        return ['result' => 'error', 'status' => false, 'Message' => 'Is not owner of dream!'];
    }
}
