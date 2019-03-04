<?php

namespace App\Http\Controllers\Admin\Filter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductType;
use App\Category;
use App\ThemeGroup;
use App\ThemeSubGroup;
use App\QuestionSubject;
use App\Question;

use App\Complexity;
use Illuminate\Database\QueryException;

class FilterController extends Controller
{
    public function index()
    {
        $data = [
            'products'     => ProductType::all(),
            'types'        => request()->has('types_product_type_id') ? Category::where('product_type_id', request('types_product_type_id'))->get() : Category::all(),
            'groups'       => request()->has('groups_category_id') ? ThemeGroup::where('category_id', request('groups_category_id'))->get() : ThemeGroup::all(),
            'sub_groups'   => request()->has('sub_groups_group_id') ? ThemeSubGroup::where('group_id', request('sub_groups_group_id'))->get() : ThemeSubGroup::all(),
            'themes'       => request()->has('themes_sub_group_id') ? QuestionSubject::where('sub_group_id', request('themes_sub_group_id'))->get() : QuestionSubject::all(),
            'complexities' => Complexity::all(),
            'target'       => urldecode(request('target')),
        ];

        return view('admin.filtros_admin', $data);
    }

    public function createCategory()
    {
        Category::create(['name' => request('name'), 'product_type_id' => request('product_type_id')]);
        return redirect()->back();
    }

    public function createGroup()
    {
        ThemeGroup::create(['name' => request('name'), 'category_id' => request('category_id')]);
        return redirect()->back();
    }

    public function createSubGroup()
    {
        ThemeSubGroup::create(['name' => request('name'), 'group_id' => request('group_id')]);
        return redirect()->back();
    }

    public function createTheme()
    {
        QuestionSubject::create(['name' => request('name'), 'sub_group_id' => request('sub_group_id')]);
        return redirect()->back();
    }

    public function createComplexity()
    {
        Complexity::create(['name' => request('name')]);
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        try {
            Category::destroy($id);
        return redirect()->back()->with(['target' => '#tipos-tab']);
        } catch (QueryException $e) {

        }
    }

    public function deleteGroup($id)
    {
        try {
            ThemeGroup::destroy($id);
        } catch (QueryException $e) {

        }
        return redirect()->back()->with(['target' => '#grupos-tab']);
    }

    public function deleteSubGroup($id)
    {
        try {
            ThemeSubGroup::destroy($id);
        } catch (QueryException $e) {

        }
        return redirect()->back()->with(['target' => '#subgrupos-tab']);
    }

    public function deleteTheme($id)
    {
        try {
            QuestionSubject::destroy($id);
        } catch (QueryException $e) {

        }
        return redirect()->back()->with(['target' => '#temas-tab']);
    }

    public function deleteComplexity($id)
    {
        try {
            Complexity::destroy($id);
        } catch (QueryException $e) {

        }
        return redirect()->back();
    }
    public function findCategory($id)
    {
        try {
            //relaciones con la tabla grupos
            $category = Category::find($id);
            $themegroups = $category->theme_groups;
            $response = [];
            foreach ($themegroups as $key => $group) {
                $response["id_group"][] = $group["id"];
                $response[] = $group;
            }
            if (!empty($response['id_group']))
            {
                $themesubgroups = ThemeSubGroup::whereIn('group_id', $response['id_group'])->get();
                foreach ($themesubgroups as $key => $subgroup) {
                    $response["id_subgroup"][] = $subgroup["id"];
                    $response[][$subgroup["group_id"]] = $subgroup;
                }
                if (!empty($response['id_subgroup'])) {
                    $questionsubject = QuestionSubject::whereIn('sub_group_id', $response['id_subgroup'])->get();
                    foreach ($questionsubject as $key => $questionsub) {
                        $response["id_questionsub"][] = $questionsub["id"];

                        $response[]['children'][$questionsub["sub_group_id"]] = $questionsub;
                    }
                    if (!empty($response['children']['children'])) {

                        $questions = Question::whereIn('subject_id', $response['id_questionsub'])->get();
                        foreach ($variable as $key => $question) {
                            $response[]['children']['children'][$question['subject_id']] = $question;
                        }
                    }
                }
            }
            $result = $response;
        } catch (QueryException $e) {
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => $result], 200);
    }
    public function findGroup($id)
    {
        try {
            //relaciones con la tabla grupos
            $themegroups = ThemeGroup::find($id);
            $themesubgroups = $themegroups->theme_sub_groups;
            $response = [];

            foreach ($themesubgroups as $key => $subgroup) {
                $response["id_subgroup"][] = $subgroup["id"];
                $response[] = $subgroup;
            }
            if (!empty($response["id_subgroup"])) {
                $questionsubject = QuestionSubject::whereIn('sub_group_id', $response["id_subgroup"])->get();
                foreach ($questionsubject as $key => $questionsub) {
                    $response["id_questionsub"][] = $questionsub["id"];
                    $response["children"][] = $questionsub;
                }
                if (!empty($response["id_questionsub"])) {
                    $response["children"]["children"][] = Question::whereIn('subject_id', $response["id_questionsub"])->get();
                }
            }
            $result = $response;
        } catch (QueryException $e) {
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => $result], 200);
    }
    public function findSubGroup($id)
    {
        try {
            //relaciones con la tabla grupos
            $themesubgroups = ThemeSubGroup::find($id);
            $questionsubject = $themesubgroups->question_subjects;
            $response = [];

            foreach ($questionsubject as $key => $questionsub) {
                $response["id_questionsub"][] = $questionsub["id"];
                $response["children"][] = $questionsub;
            }
            if (!empty($response["id_questionsub"])) {
                $response["children"]["children"][] = Question::whereIn('subject_id', $response["id_questionsub"])->get();
            }
            $result = $response;
        } catch (QueryException $e) {
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => $result], 200);
    }
    public function findTheme($id)
    {
        try {
            $response = Question::where('subject_id', $id)->get();
            $result = $response;
        } catch (QueryException $e) {
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => $result], 200);
    }
}
