<?php
namespace App\Http\Controllers\Students;

use App\Student;
use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{    
    protected $prefix = 'Students\\';
    # VALIDATOR
    protected $name = 'required|max:50';
    protected $email = 'required|max:35';
    protected $phone = 'required|max:8';
    protected $school = 'required';
    
    /*
    |--------------------------------------------------------------------------
    | SHOW STUDENT TABLE AND INSERT FORM
    |--------------------------------------------------------------------------
    */
    protected function index()
    {
        $students = Student::all();
        $schools = School::all();
        return view($this->prefix.'_student_add',[
            'students'=>$students,
            'schools'=>$schools
        ]);
    }
    
    /*
    |--------------------------------------------------------------------------
    | FORM VALIDATOR AND ADD METHOD
    |--------------------------------------------------------------------------
    */
    protected function validator(array $student)
    {
        return Validator::make($student, [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->name,
            'school' => $this->school
        ]);
    }
        
    protected function add(Request $request)
    {
        $this->validator($request->all())->validate();        
        Student::create([
            'school_id'=>$request->school,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone
        ]);
           
        return $this->redirect();
    }
    
    /*
    |--------------------------------------------------------------------------
    | SHOW FORM TO EDIT AND EDIT METHOD
    |--------------------------------------------------------------------------
    */
    protected function showEditForm($id)
    {
        $student = Student::find($id);
        $schools = School::all();
        
        return view($this->prefix.'_student_edit',[
            'id'=>$id,
            'school_id'=>$student->school_id,
            'name'=>$student->name,
            'email'=>$student->email,
            'phone'=>$student->phone,
            'schools'=>$schools
        ]);
    }  
    
    protected function edit(Request $request, $id)
    {
        $this->validator($request->all())->validate();
        
        $student = Student::find($id);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->school_id = $request->school;
        $student->save();
        
        return $this->redirect();
    }
    
    /*
    |--------------------------------------------------------------------------
    | DELETE STUDENT
    |--------------------------------------------------------------------------
    */
    protected function delete($id)
    {
        Student::destroy($id);
        
        return $this->redirect();
    }
    
    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */
    protected function redirect()
    {
        return redirect(url('/student_add'));
    }
}