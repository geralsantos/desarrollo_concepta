<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

Route::get('login', function(){
    return view('templates.login');
})->name('login');

Route::get('/alumnos', function () {
    return view('alumnos.cursos_alumnos');
})->name('alumnos');



Route::get('/alumnos/evaluaciones', function () {
    return view('alumnos.evaluaciones_alumnos');
});

Route::get('/alumnos/cursoejemplo', function () {
    return view('alumnos.cursoejemplo');
});

Route::get('/alumnos/sesionejemplo', function () {
    return view('alumnos.sesion_ejemplo');
});

Route::get('/pruebas', function () {
    return view('alumnos.pruebas');
});

/**** DOCENTES *****/

Route::get('/docentes/cursos', function () {
    return view('docentes.cursos_docentes');
});

Route::get('/docentes/cursos/curso_ejemplo', function () {
    return view('docentes.curso_ejemplo');
});

Route::get('/docentes/cursos/sesion_ejemplo', function () {
    return view('docentes.sesion_ejemplo');
});

Route::get('/docentes/cursos/editar_tema', function () {
    return view('docentes.editar_tema');
});

Route::get('/docentes/cursos/formulario', function () {
    return view('docentes.formulario_correccion');
});

Route::get('/docentes/config', function () {
    return view('docentes.configuser');
});

/**** COORDINADOR EMPRESA *****/

Route::get('/coordinador_empresa/cursos', function () {
    return view('coordinador_empresa.cursos_coordinador_empresa');
});

Route::get('/coordinador_empresa/simuladores', function () {
    return view('coordinador_empresa.simuladores_coordinador_empresa');
});

Route::get('/coordinador_empresa/evaluaciones', function () {
    return view('coordinador_empresa.evaluaciones_coordinador_empresa');
});

Route::get('/coordinador_empresa/colaboradores', function () {
    return view('coordinador_empresa.colaboradores_coordinador_empresa');
});

Route::get('/coordinador_empresa/curso_ejemplo', function () {
    return view('coordinador_empresa.curso_ejemplo');
});

Route::get('/coordinador_empresa/sesion_ejemplo', function () {
    return view('coordinador_empresa.curso_ejemplo');
});

Route::get('/coordinador_empresa/simulador_ejemplo', function () {
    return view('coordinador_empresa.simulador_ejemplo');
});

Route::get('/coordinador_empresa/evaluacion_ejemplo', function () {
    return view('coordinador_empresa.evaluacion_ejemplo');
});

Route::get('/coordinador_empresa/config', function () {
    return view('coordinador_empresa.configuser');
});

/**** ADMIN *****/

Route::get('/admin/empresas', function () {
    return view('admin.empresas_admin');
});


/**** ALUMNO *****/
Route::get('/alumnos/certificados', function () {
    return view('alumnos.certificados_alumnos');
});

Route::get('/alumnos/config', function () {
    return view('alumnos.configuser');
});


Route::group(['as' => 'user', 'prefix' => 'alumnos', 'namespace' => 'Student'], function(){
   Route::group(['as' => '.auth', 'prefix' => 'auth', 'namespace' => 'Auth'], function(){
        Route::get('logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
        //Route::get('login', ['as' => '.login', 'uses' => 'LoginController@showLogin']);
        Route::post('login', ['as' => '.login', 'uses' => 'LoginController@login']);
    });
    Route::group(['prefix' => 'cursos', 'as' => '.courses', 'namespace' => 'Course', 'middleware' => 'auth:web'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'CourseController@index']);
        Route::get('{id}/detalle', ['as' => '.detail', 'uses' => 'CourseController@showDetail']);
        Route::get('temas/{id}/detalle', ['as' => '.theme-detail', 'uses' => 'ThemeController@showDetail']);
        Route::post('save-annotation', ['as' => '.save-annotation', 'uses' => 'CourseController@saveAnnotation']);
    });

    Route::group(['prefix' => 'simuladores', 'as' => '.simulators', 'namespace' => 'Simulator', 'middleware' => 'auth:web'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'SimulatorController@index']);
    });

    Route::group(['prefix' => 'evaluaciones', 'as' => '.exams', 'namespace' => 'Exam', 'middleware' => 'auth:web'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ExamController@index']);
    });

    Route::group(['prefix' => 'certificados', 'as' => '.certificates', 'namespace' => 'Certificate', 'middleware' => 'auth:web'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'CertificateController@index']);
    });

    Route::group(['prefix' => 'questions', 'as' => '.questions', 'namespace' => 'Question', 'middleware' => 'auth:web'], function(){
        Route::get('form', ['as' => '.form', 'uses' => 'QuestionController@showForm']);
        Route::post('form', ['as' => '.form', 'uses' => 'QuestionController@submitForm']);
        Route::get('nota', ['as' => '.result-review', 'uses' => 'QuestionController@resultReview']);
        Route::get('back-review', ['as' => '.back-review', 'uses' => 'QuestionController@backReview']);
    });

    Route::group(['prefix' => 'desempeno', 'as' => '.progress', 'namespace' => 'Progress', 'middleware' => 'auth:web'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ProgressController@index']);
    });

    Route::group(['as' => '.config', 'prefix' => 'config', 'namespace' => 'Config', 'middleware' => 'auth:web'], function(){
        Route::get('{id}/user', ['as' => '.user', 'uses' => 'ConfigUserController@index']);
        Route::post('update', ['as' => '.update', 'uses' => 'ConfigUserController@update']);

    });


});


Route::group(['as' => 'company', 'prefix' => 'coordinadores', 'namespace' => 'Company'], function(){
    Route::group(['prefix' => 'cursos', 'as' => '.courses', 'namespace' => 'Course', 'middleware' => 'auth:company'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'CourseController@index']);
        Route::get('{id}/detalle', ['as' => '.detail', 'uses' => 'CourseController@detail']);
        Route::post('save-assistances', ['as' => '.save-assistances', 'uses' => 'CourseController@saveAssistances']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'CourseController@postEdit']);
    });

    Route::group(['prefix' => 'temas', 'as' => '.themes', 'namespace' => 'Course', 'middleware' => 'auth:company'], function(){
        Route::get('{id}/detail', ['as' => '.detail', 'uses' => 'ThemeController@detail']);
    });

    Route::group(['as' => '.products', 'prefix' => 'productos', 'namespace' => 'Product'], function(){
        Route::post('{id}/add-student', ['as' => '.add-student', 'uses' => 'ProductController@addStudent']);
    });

    Route::group(['prefix' => 'simuladores', 'as' => '.simulators', 'namespace' => 'Simulator', 'middleware' => 'auth:company'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'SimulatorController@index']);
        Route::get('{id}/detail', ['as' => '.detail', 'uses' => 'SimulatorController@detail']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'SimulatorController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'SimulatorController@postEdit']);
    });

    Route::group(['prefix' => 'evaluaciones', 'as' => '.exams', 'namespace' => 'Exam', 'middleware' => 'auth:company'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ExamController@index']);
        Route::get('{id}/detail', ['as' => '.detail', 'uses' => 'ExamController@detail']);
    });


    /*
    Route::group(['prefix' => 'evaluaciones', 'as' => '.exams', 'namespace' => 'Exam', 'middleware' => 'auth:company'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ExamController@index']);
    });
    */

    Route::group(['prefix' => 'personal', 'as' => '.students', 'namespace' => 'Student', 'middleware' => 'auth:company'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'StudentController@index']);
        Route::post('json-create', ['as' => '.json-create', 'uses' => 'StudentController@jsonCreate']);
    });

    Route::group(['prefix' => 'auth', 'as' => '.auth', 'namespace' => 'Auth'], function(){
        //Route::get('login', ['as' => '.login', 'uses' => 'LoginController@showLogin']);
        Route::get('logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
        Route::post('login', ['as' => '.login', 'uses' => 'LoginController@login']);
    });

    Route::group(['as' => '.config', 'prefix' => 'config', 'namespace' => 'Config', 'middleware' => 'auth:company'], function(){
        Route::get('{id}/user', ['as' => '.user', 'uses' => 'ConfigUserController@index']);
        Route::post('update', ['as' => '.update', 'uses' => 'ConfigUserController@update']);

    });
});

Route::group(['prefix' => 'docentes', 'as' => 'teacher', 'namespace' => 'Teacher'], function(){
    Route::group(['prefix' => 'auth', 'as' => '.auth', 'namespace' => 'Auth'], function(){
        //Route::get('login', ['as' => '.login', 'uses' => 'LoginController@showLogin']);
        Route::get('logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
        Route::post('login', ['as' => '.login', 'uses' => 'LoginController@login']);
    });

    Route::group(['as' => '.courses', 'prefix' => 'cursos', 'namespace' => 'Course', 'middleware' => 'auth:teacher'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'CourseController@index']);
        //Route::get('{id}/detalle', ['as' => '.detail', 'uses' => 'CourseController@detail']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'CourseController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'CourseController@postEdit']);
        Route::post('save-assistances', ['as' => '.save-assistances', 'uses' => 'CourseController@saveAssistances']);
        Route::group(['as' => '.activities', 'prefix' => 'actividades', 'namespace' => 'Activity', 'middleware' => 'auth:teacher'], function(){
            Route::post('', ['as' => '.create', 'uses' => 'ActivityController@create']);
            Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'ActivityController@edit']);
            Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'ActivityController@delete']);
        });
        Route::group(['as' => '.exams', 'prefix' => 'examenes', 'namespace' => 'Exam', 'middleware' => 'auth:teacher'], function(){
            Route::post('', ['as' => '.create', 'uses' => 'CourseExamController@create']);
            Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'CourseExamController@edit']);
            Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'CourseExamController@delete']);
        });
    });

    Route::group(['as' => '.themes', 'prefix' => 'temas', 'namespace' => 'Theme', 'middleware' => 'auth:teacher'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ThemeController@index']);
        Route::get('crear', ['as' => '.create', 'uses' => 'ThemeController@create']);
        Route::get('{id}/detalle', ['as' => '.detail', 'uses' => 'ThemeController@detail']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'ThemeController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'ThemeController@postEdit']);
        Route::get('{id}/student_view', ['as' => '.student-view', 'uses' => 'ThemeController@studentView']);
        Route::post('{id}/add-multimedia', ['as' => '.add-multimedia', 'uses' => 'ThemeController@addMultimedia']);
        Route::get('{id}/multimedia/{multimedia_id}/delete', ['as' => '.delete-multimedia', 'uses' => 'ThemeController@deleteMultimedia']);
        Route::post('{id}/add-attachment', ['as' => '.add-attachment', 'uses' => 'ThemeController@addAttachment']);
        Route::get('{id}/attachment/{attachment_id}/delete', ['as' => '.delete-attachment', 'uses' => 'ThemeController@deleteAttachment']);
        Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'ThemeController@delete']);
        Route::get('{id}/add-exercise', ['as' => '.add-exercise', 'uses' => 'ThemeController@addExercise']);
        Route::get('{id}/exercises/{exercise_id}/edit', ['as' => '.edit-exercise', 'uses' => 'ThemeController@editExercise']);
        Route::get('{id}/exercises/{exercise_id}/delete', ['as' => '.delete-exercise', 'uses' => 'ThemeController@deleteExercise']);
    });

    Route::group(['as' => '.questions', 'prefix' => 'questions', 'namespace' => 'Question', 'middleware' => 'auth:teacher'], function(){
        Route::get('review', ['as' => '.review', 'uses' => 'QuestionController@showReview']);
        Route::post('review', ['as' => '.review', 'uses' => 'QuestionController@review']);
        Route::get('create', ['as' => '.create', 'uses' => 'QuestionController@showCreate']);
        Route::post('create', ['as' => '.create', 'uses' => 'QuestionController@create']);
        Route::post('sync', ['as' => '.sync', 'uses' => 'QuestionController@sync']);
        Route::post('filter', ['as' => '.filter', 'uses' => 'QuestionController@filter']);
        Route::get('detach', ['as' => '.detach', 'uses' => 'QuestionController@detach']);
    });

    Route::group(['as' => '.sessions', 'prefix' => 'sesiones', 'namespace' => 'Session', 'middleware' => 'auth:teacher'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'SessionController@index']);
        Route::get('crear', ['as' => '.create', 'uses' => 'SessionController@create']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'SessionController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'SessionController@postEdit']);
        Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'SessionController@delete']);
    });

    Route::group(['as' => '.keywords', 'prefix' => 'keywords', 'namespace' => 'Keyword', 'middleware' => 'auth:teacher'], function(){
        Route::get('', ['as' => '.json-all', 'uses' => 'KeywordController@jsonAll']);
    });

    Route::group(['as' => '.config', 'prefix' => 'config', 'namespace' => 'Config', 'middleware' => 'auth:teacher'], function(){
        Route::get('{id}/user', ['as' => '.user', 'uses' => 'ConfigUserController@index']);
        Route::post('update', ['as' => '.update', 'uses' => 'ConfigUserController@update']);
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin', 'namespace' => 'Admin'], function(){
    Route::group(['as' => '.auth', 'namespace' => 'Auth'], function(){
        Route::get('login', ['as' => '.login', 'uses' => 'LoginController@showLogin']);
        Route::get('logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
        Route::post('login', ['as' => '.login', 'uses' => 'LoginController@login']);
    });

    Route::group(['as' => '.courses', 'prefix' => 'cursos', 'namespace' => 'Course', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'CourseController@index']);
        Route::get('crear', ['as' => '.create', 'uses' => 'CourseController@create']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'CourseController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'CourseController@postEdit']);
        Route::post('delete', ['as' => '.delete', 'uses' => 'CourseController@delete']);
        Route::group(['as' => '.certificates', 'prefix' => 'certificados', 'namespace' => 'Certificate'], function(){
            Route::post('', ['as' => '.create', 'uses' => 'CertificateController@create']);
            Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'CertificateController@delete']);
            Route::get('', ['as' => '.view', 'uses' => 'CertificateController@view']);
        });
        Route::group(['as' => '.activities', 'prefix' => 'actividades', 'namespace' => 'Activity', 'middleware' => 'auth:admin'], function(){
            Route::post('', ['as' => '.create', 'uses' => 'ActivityController@create']);
            Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'ActivityController@edit']);
            Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'ActivityController@delete']);
        });
        Route::group(['as' => '.exams', 'prefix' => 'examenes', 'namespace' => 'Exam', 'middleware' => 'auth:admin'], function(){
            Route::post('', ['as' => '.create', 'uses' => 'CourseExamController@create']);
            Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'CourseExamController@edit']);
            Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'CourseExamController@delete']);
        });
    });

    Route::group(['as' => '.sessions', 'prefix' => 'sesiones', 'namespace' => 'Session', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'SessionController@index']);
        Route::get('crear', ['as' => '.create', 'uses' => 'SessionController@create']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'SessionController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'SessionController@postEdit']);
        Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'SessionController@delete']);
    });

    Route::group(['as' => '.themes', 'prefix' => 'temas', 'namespace' => 'Theme', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ThemeController@index']);
        Route::get('crear', ['as' => '.create', 'uses' => 'ThemeController@create']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'ThemeController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'ThemeController@postEdit']);
        Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'ThemeController@delete']);
        Route::post('{id}/add-multimedia', ['as' => '.add-multimedia', 'uses' => 'ThemeController@addMultimedia']);
        Route::get('{id}/multimedia/{multimedia_id}/delete', ['as' => '.delete-multimedia', 'uses' => 'ThemeController@deleteMultimedia']);
        Route::post('{id}/add-attachment', ['as' => '.add-attachment', 'uses' => 'ThemeController@addAttachment']);
        Route::get('{id}/attachment/{attachment_id}/delete', ['as' => '.delete-attachment', 'uses' => 'ThemeController@deleteAttachment']);
        Route::get('{id}/add-exercise', ['as' => '.add-exercise', 'uses' => 'ThemeController@addExercise']);
        Route::get('{id}/exercises/{exercise_id}/edit', ['as' => '.edit-exercise', 'uses' => 'ThemeController@editExercise']);
        Route::get('{id}/exercises/{exercise_id}/delete', ['as' => '.delete-exercise', 'uses' => 'ThemeController@deleteExercise']);
        Route::get('{id}/student_view', ['as' => '.student-view', 'uses' => 'ThemeController@studentView']);
    });

    Route::group(['as' => '.questions', 'prefix' => 'questions', 'namespace' => 'Question', 'middleware' => 'auth:admin'], function(){
        Route::get('create', ['as' => '.create', 'uses' => 'QuestionController@showCreate']);
        Route::post('create', ['as' => '.create', 'uses' => 'QuestionController@create']);
        Route::post('sync', ['as' => '.sync', 'uses' => 'QuestionController@sync']);
        Route::post('filter', ['as' => '.filter', 'uses' => 'QuestionController@filter']);
        Route::get('detach', ['as' => '.detach', 'uses' => 'QuestionController@detach']);
        Route::get('review', ['as' => '.review', 'uses' => 'QuestionController@showReview']);
        Route::post('review', ['as' => '.review', 'uses' => 'QuestionController@review']);
        Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'QuestionController@delete']);

    });

    Route::group(['as' => '.keywords', 'prefix' => 'keywords', 'namespace' => 'Keyword', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.json-all', 'uses' => 'KeywordController@jsonAll']);
    });

    Route::group(['as' => '.students', 'prefix' => 'alumnos', 'namespace' => 'Student', 'middleware' => 'auth:admin'], function(){
        Route::post('json-create', ['as' => '.json-create', 'uses' => 'StudentController@jsonCreate']);
        Route::post('create', ['as' => '.create', 'uses' => 'StudentController@create']);
    });

    Route::group(['as' => '.teachers', 'prefix' => 'docentes', 'namespace' => 'Teacher', 'middleware' => 'auth:admin'], function(){
        Route::post('json-create', ['as' => '.json-create', 'uses' => 'TeacherController@jsonCreate']);
        Route::post('create', ['as' => '.create', 'uses' => 'TeacherController@create']);
    });

    Route::group(['as' => '.companies', 'prefix' => 'emperesas', 'namespace' => 'Company', 'middleware' => 'auth:admin'], function(){
        Route::post('create', ['as' => '.create', 'uses' => 'CompanyController@create']);
    });

    Route::group(['as' => '.businesses', 'prefix' => 'negocios', 'namespace' => 'Business', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'BusinessController@index']);
        Route::post('create', ['as' => '.create', 'uses' => 'BusinessController@create']);
        Route::post('{id}/add-products', ['as' => '.add-products', 'uses' => 'BusinessController@addProducts']);
        Route::post('{id}/update-products', ['as' => '.update-products', 'uses' => 'BusinessController@updateProducts']);
    });

    Route::group(['as' => '.admins', 'prefix' => 'admins', 'namespace' => 'Admin', 'middleware' => ['auth:admin', 'admin.permissions']], function(){
        Route::post('create', ['as' => '.create', 'uses' => 'AdminController@create']);
    });

    Route::group(['as' => '.simulators', 'prefix' => 'simuladores', 'namespace' => 'Simulator', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'SimulatorController@index']);
        Route::get('crear', ['as' => '.create', 'uses' => 'SimulatorController@create']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'SimulatorController@edit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'SimulatorController@postEdit']);
        Route::post('{id}/add-attachment', ['as' => '.add-attachment', 'uses' => 'SimulatorController@addAttachment']);
        Route::get('{id}/attachment/{attachment_id}/delete', ['as' => '.delete-attachment', 'uses' => 'SimulatorController@deleteAttachment']);
        Route::post('delete', ['as' => '.delete', 'uses' => 'SimulatorController@delete']);
        Route::group(['as' => '.categories', 'prefix' => 'categorias', 'namespace' => 'Category'], function(){
            Route::post('' ,['as' => '.create', 'uses' => 'CategoryController@create']);
        });
        Route::group(['as' => '.exams', 'prefix' => 'examenes', 'namespace' => 'Exam'], function(){
            Route::post('' ,['as' => '.create', 'uses' => 'ExamController@create']);
            Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'ExamController@showEdit']);
            Route::get('{id}/delete', ['as' => '.delete', 'uses' => 'ExamController@delete']);
        });
    });

    Route::group(['as' => '.accounts', 'prefix' => 'cuentas', 'namespace' => 'Account', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'AccountController@index']);
        Route::get('find', ['as' => '.find', 'uses' => 'AccountController@find']);
        Route::post('edit', ['as' => '.edit', 'uses' => 'AccountController@edit']);
    });

    Route::group(['as' => '.exams', 'prefix' => 'evaluaciones', 'namespace' => 'Exam', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'ExamController@index']);
        Route::post('', ['as' => '.create', 'uses' => 'ExamController@create']);
        Route::get('{id}/edit', ['as' => '.edit', 'uses' => 'ExamController@showEdit']);
        Route::post('{id}/edit', ['as' => '.edit', 'uses' => 'ExamController@edit']);
        
        Route::post('delete', ['as' => '.delete', 'uses' => 'ExamController@delete']);
        Route::group(['as' => '.categories', 'prefix' => 'categorias', 'namespace' => 'Category'], function(){
            Route::post('' ,['as' => '.create', 'uses' => 'CategoryController@create']);
            Route::post('delete', ['as' => '.delete', 'uses' => 'CategoryController@delete']);
        });
    });

    Route::group(['as' => '.filters', 'prefix' => 'filtros', 'namespace' => 'Filter', 'middleware' => 'auth:admin'], function(){
        Route::get('', ['as' => '.index', 'uses' => 'FilterController@index']);
        Route::post('create-category', ['as' => '.create-category', 'uses' => 'FilterController@createCategory']);
        Route::post('create-group', ['as' => '.create-group', 'uses' => 'FilterController@createGroup']);
        Route::post('create-sub-group', ['as' => '.create-sub-group', 'uses' => 'FilterController@createSubGroup']);
        Route::post('create-theme', ['as' => '.create-theme', 'uses' => 'FilterController@createTheme']);
        Route::post('create-complexity', ['as' => '.create-complexity', 'uses' => 'FilterController@createComplexity']);
        Route::get('{id}/delete-category', ['as' => '.delete-category', 'uses' => 'FilterController@deleteCategory']);
        Route::get('{id}/delete-group', ['as' => '.delete-group', 'uses' => 'FilterController@deleteGroup']);
        Route::get('{id}/delete-sub-group', ['as' => '.delete-sub-group', 'uses' => 'FilterController@deleteSubGroup']);
        Route::get('{id}/delete-theme', ['as' => '.delete-theme', 'uses' => 'FilterController@deleteTheme']);
        Route::get('{id}/delete-complexity', ['as' => '.delete-complexity', 'uses' => 'FilterController@deleteComplexity']);
        Route::get('{id}/find-category', ['as' => '.find-category', 'uses' => 'FilterController@findCategory']);
        Route::get('{id}/find-group', ['as' => '.find-group', 'uses' => 'FilterController@findGroup']);
        Route::get('{id}/find-sub-group', ['as' => '.find-sub-group', 'uses' => 'FilterController@findSubGroup']);
        Route::get('{id}/find-theme', ['as' => '.find-theme', 'uses' => 'FilterController@findTheme']);

    });
    Route::group(['as' => '.config', 'prefix' => 'config', 'namespace' => 'Config', 'middleware' => 'auth:admin'], function(){
        Route::get('{id}/user', ['as' => '.user', 'uses' => 'ConfigUserController@index']);
        Route::post('update', ['as' => '.update', 'uses' => 'ConfigUserController@update']);

    });
   
});
