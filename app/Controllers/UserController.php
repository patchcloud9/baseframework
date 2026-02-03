<?php

namespace App\Controllers;

use App\Models\User;

/**
 * User Controller
 * 
 * Manages user CRUD operations using the User model.
 */
class UserController extends Controller
{
    /**
     * List all users
     * Route: GET /users
     */
    public function index(): void
    {
        $users = User::all();
        
        $this->view('users/index', [
            'title' => 'All Users',
            'users' => $users,
        ]);
    }
    
    /**
     * Show a single user
     * Route: GET /users/(\d+)
     * 
     * @param string $id The user ID captured from the URL
     */
    public function show(string $id): void
    {
        // Note: $id comes as a string from the URL
        // Convert to int for database lookup
        $userId = (int) $id;
        
        $user = User::find($userId);
        
        // Check if user exists
        if (!$user) {
            $this->view('errors/404', [
                'title' => 'User Not Found',
                'message' => "No user found with ID: {$id}",
            ], null);
            return;
        }
        
        $this->view('users/show', [
            'title' => $user['name'],
            'user' => $user,
            'requestedId' => $id,  // Show the raw value from URL
        ]);
    }
    
    /**
     * Show edit form for a user
     * Route: GET /users/(\d+)/edit
     */
    public function edit(string $id): void
    {
        $userId = (int) $id;
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->flash('error', "User {$id} not found");
            $this->redirect('/users');
            return;
        }
        
        $this->view('users/edit', [
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }
    
    /**
     * Create a new user (handle form submission)
     * Route: POST /users
     */
    public function store(): void
    {
        // Rate limiting: 3 users per 5 minutes
        $rateLimiter = new \Core\RateLimiter();
        if (!$rateLimiter->attempt('user-creation', 3, 300)) {
            $this->json([
                'success' => false,
                'message' => 'Too many user creation attempts. Please try again later.',
            ], 429);
            return;
        }
        
        // Validate input
        $validator = new \Core\Validator($_POST, [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255',
        ]);
        
        if ($validator->fails()) {
            $this->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
            return;
        }
        
        $name = $this->input('name');
        $email = $this->input('email');
        $password = $this->input('password');
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
        ]);
        
        $this->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }
    
    /**
     * Update an existing user
     * Route: POST /users/(\d+)
     */
    public function update(string $id): void
    {
        $this->verifyCsrf();
        
        $userId = (int) $id;
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->json([
                'success' => false,
                'message' => "User {$id} not found",
            ], 404);
            return;
        }
        
        // Build validation rules dynamically based on what's being updated
        $rules = [];
        $postData = [];
        
        if ($this->input('name') !== null) {
            $rules['name'] = 'required|min:2|max:100';
            $postData['name'] = $this->input('name');
        }
        
        if ($this->input('email') !== null) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $userId;
            $postData['email'] = $this->input('email');
        }
        
        if ($this->input('password') !== null && $this->input('password') !== '') {
            $rules['password'] = 'required|min:8|max:255';
            $postData['password'] = $this->input('password');
        }
        
        if ($this->input('role') !== null) {
            $rules['role'] = 'required|in:admin,user,guest';
            $postData['role'] = $this->input('role');
        }
        
        // Validate if there are any rules
        if (!empty($rules)) {
            $validator = new \Core\Validator($postData, $rules);
            
            if ($validator->fails()) {
                $this->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
                return;
            }
        }
        
        // Get update data (filter out password if empty)
        $data = [];
        if ($name = $this->input('name')) {
            $data['name'] = $name;
        }
        if ($email = $this->input('email')) {
            $data['email'] = $email;
        }
        if ($password = $this->input('password')) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        if ($role = $this->input('role')) {
            $data['role'] = $role;
        }
        
        User::update($userId, $data);
        
        $this->json([
            'success' => true,
            'message' => "User {$id} updated successfully",
            'data' => User::find($userId),
        ]);
    }
    
    /**
     * Delete a user
     * Route: DELETE /users/(\d+)
     */
    public function destroy(string $id): void
    {
        $this->verifyCsrf();
        
        $userId = (int) $id;
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->json([
                'success' => false,
                'message' => "User {$id} not found",
            ], 404);
            return;
        }
        
        User::delete($userId);
        
        $this->json([
            'success' => true,
            'message' => "User {$id} deleted successfully",
        ]);
    }
}
