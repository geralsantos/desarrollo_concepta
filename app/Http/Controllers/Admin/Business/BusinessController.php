<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Business;
use App\ProductType;
use App\Course;
use App\Exam;
use App\Simulator;

class BusinessController extends Controller
{
    public function create()
    {
        $data = request()->all();
        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.businesses.logos'), 'public') : null;

        $teacher = Business::create([
            'ruc' => $data['ruc'],
            'social_reason' => $data['social_reason'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'contact_email' => $data['contact_email'],
            'contact_name' => $data['contact_name'],
            'logo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return redirect()->back();
    }

    public function index()
    {
        $data = [
            'businesses' => Business::all(),
            'product_types' => ProductType::all(),
            'courses' => Course::all(),
            'exams' => Exam::all(),
            'simulators' => Simulator::all(),
        ];

        return view('admin.empresas', $data);
    }

    public function addProducts($id, Request $request)
    {
        $business = Business::find($id);

        switch ($request->get('product_type_id')) {
            case PRODUCT_COURSE: {
                $courses = $request->get('courses');
                foreach ($courses as $course_id) {
                    $business->products()->attach(Course::find($course_id)->product_id);
                }
                break;
            }
            case PRODUCT_SIMULATOR: {
                $simulators = $request->get('simulators');
                foreach ($simulators as $simulator_id) {
                    $business->products()->attach(Simulator::find($simulator_id)->product_id);
                }
                break;
            }
            case PRODUCT_EXAM: {
                $exams = $request->get('exams');
                foreach ($exams as $exam_id) {
                    $business->products()->attach(Exam::find($exam_id)->product_id);
                }
                break;
            }
        }

        return redirect()->back();
    }

    public function updateProducts($id, Request $request)
    {
        $business = Business::find($id);
        $business->products()->sync($request->get('products'));

        return redirect()->back();
    }
}
