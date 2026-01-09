<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Users (Keep Existing)
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'role' => User::ROLE_ADMIN,
        ]);

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('Test1234!'),
        ]);

        // 2. Create 3 Posts
        $postsData = [
            [
                'title' => 'Welcome to Blogify',
                'slug' => 'welcome-to-blogify',
                'image' => null, // Placeholder or null
                'content' => 'This is the very first post on Blogify. We are excited to start this journey with you!',
                'published_at' => now(),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'The Future of AI',
                'slug' => 'the-future-of-ai',
                'image' => null,
                'content' => 'Artificial Intelligence is rapidly evolving. From machine learning to generative models, the possibilities are endless.',
                'published_at' => now()->subDay(),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Laravel 11 Features',
                'slug' => 'laravel-11-features',
                'image' => null,
                'content' => 'Laravel 11 introduces a streamlined application structure, per-second rate limiting, and health routing.',
                'published_at' => now()->subDays(2),
                'user_id' => $testUser->id,
            ],
        ];

        foreach ($postsData as $postData) {
            $post = Post::create($postData);

            // 4. Create dummy comments for each post
            $comment1 = Comment::create([
                'post_id' => $post->id,
                'user_id' => $testUser->id,
                'content' => 'Great post! I learned a lot.',
            ]);

            $comment2 = Comment::create([
                'post_id' => $post->id,
                'user_id' => $admin->id,
                'content' => 'Thank you for sharing this insight.',
            ]);
            
            // Randomly add a third comment
            if (rand(0, 1)) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $testUser->id,
                    'content' => 'Looking forward to more content like this.',
                ]);
            }

            // 5. Add Post Likes (New)
            // Admin likes all posts, Test User likes random ones
            $post->likes()->attach($admin->id);
            if (rand(0, 1)) {
                $post->likes()->attach($testUser->id);
            }

            // 6. Add Saved Comments (New)
            // Admin saves test user's comment
            $admin->savedComments()->attach($comment1->id);
            // Test user saves admin's comment
            $testUser->savedComments()->attach($comment2->id); 
        }

        // 3. Create 2 FAQ Categories with 2 Questions each
        $categories = [
            'General' => [
                'description' => 'General questions about the platform',
                'faqs' => [
                    [
                        'question' => 'What is Blogify?',
                        'answer' => 'Blogify is a robust blogging platform built with Laravel.',
                    ],
                    [
                        'question' => 'Is it free to use?',
                        'answer' => 'Yes, Blogify is open source and free to use.',
                    ],
                ]
            ],
            'Account' => [
                'description' => 'Questions related to user accounts',
                'faqs' => [
                    [
                        'question' => 'How do I reset my password?',
                        'answer' => 'You can reset your password from the login page by clicking "Forgot Password".',
                    ],
                    [
                        'question' => 'Can I delete my account?',
                        'answer' => 'Currently, you need to contact support to delete your account.',
                    ],
                ]
            ],
        ];

        foreach ($categories as $name => $data) {
            $category = FaqCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $data['description'],
            ]);

            foreach ($data['faqs'] as $faqData) {
                Faq::create([
                    'faq_category_id' => $category->id,
                    'question' => $faqData['question'],
                    'answer' => $faqData['answer'],
                ]);
            }
        }

        // 7. Add Messages (New)
        Message::create([
            'sender_id' => $testUser->id,
            'receiver_id' => $admin->id,
            'content' => 'Hello Admin, I have a question about my account.',
        ]);

        Message::create([
            'sender_id' => $admin->id,
            'receiver_id' => $testUser->id,
            'content' => 'Hi Test User, feel free to ask anytime!',
        ]);

        Message::create([
            'sender_id' => $testUser->id,
            'receiver_id' => $admin->id,
            'content' => 'Thanks! I wanted to know if I can change my username.',
        ]);

        // 8. Add Contacts (New)
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Partnership Inquiry',
            'message' => 'I would like to discuss a potential partnership opportunities with Blogify.',
        ]);

        Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'subject' => 'Bug Report',
            'message' => 'I found a small bug on the login page.',
        ]);
    }
}
