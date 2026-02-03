<?php

namespace App\Controllers;

/**
 * User Controller
 * 
 * Demonstrates how URL parameters work.
 * In a real app, this would interact with a database.
 */
class UserController extends Controller
{
    /**
     * Fake user data for demonstration
     */
    private array $users = [
        1 => ['id' => 1, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'role' => 'Admin'],
        2 => ['id' => 2, 'name' => 'Bob Smith', 'email' => 'bob@example.com', 'role' => 'User'],
        3 => ['id' => 3, 'name' => 'Carol Williams', 'email' => 'carol@example.com', 'role' => 'User'],
        42 => ['id' => 42, 'name' => 'The Answer', 'email' => 'answer@universe.com', 'role' => 'Admin'],
    ];
    
    /**
     * List all users
     * Route: GET /users
     */
    public function index(): void
    {
        $this->view('users/index', [
            'title' => 'All Users',
            'users' => $this->users,
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
        // Convert to int for array lookup
        $userId = (int) $id;
        
        // Check if user exists
        if (!isset($this->users[$userId])) {
            $this->view('errors/404', [
                'title' => 'User Not Found',
                'message' => "No user found with ID: {$id}",
            ], null);
            return;
        }
        
        $user = $this->users[$userId];
        
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
        
        if (!isset($this->users[$userId])) {
            $this->flash('error', "User {$id} not found");
            $this->redirect('/users');
            return;
        }
        
        $this->view('users/edit', [
            'title' => 'Edit User',
            'user' => $this->users[$userId],
        ]);
    }
    
    /**
     * Create a new user (handle form submission)
     * Route: POST /users
     */
    public function store(): void
    {
        $name = $this->input('name');
        $email = $this->input('email');
        
        // In a real app: validate, save to database
        
        // For demo, just return JSON showing what was received
        $this->json([
            'success' => true,
            'message' => 'User created (not really, this is a demo)',
            'data' => [
                'name' => $name,
                'email' => $email,
            ],
        ], 201);
    }
    
    /**
     * Update an existing user
     * Route: POST /users/(\d+)
     */
    public function update(string $id): void
    {
        $this->json([
            'success' => true,
            'message' => "User {$id} updated (not really, this is a demo)",
            'received' => $this->all(),
        ]);
    }
    
    /**
     * Delete a user
     * Route: DELETE /users/(\d+)
     */
    public function destroy(string $id): void
    {
        $this->json([
            'success' => true,
            'message' => "User {$id} deleted (not really, this is a demo)",
        ]);
    }
}
