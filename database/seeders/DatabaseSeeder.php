<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SkilledWorker;
use App\Models\WorkerWork;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Car Cleaner', 'count' => 20],
            ['name' => 'Cook', 'count' => 15],
            ['name' => 'Driver', 'count' => 25],
            ['name' => 'Electrician', 'count' => 18],
            ['name' => 'Home Instructor', 'count' => 10],
            ['name' => 'Maid', 'count' => 30],
            ['name' => 'Mechanic', 'count' => 12],
            ['name' => 'Plumber', 'count' => 22],
            ['name' => 'Tutor', 'count' => 19]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Users
        $users = [
            [
                'name' => 'Administrator User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'ADMINISTRATOR',
                'skills' => null,
                'valid_id' => null,
                'job' => null,
                'location' => null,
                'experience' => null,
                'availability' => null,
                'rating' => null,
                'phone' => null,
                'image' => 'images/image.png',
            ],
            [
                'name' => 'Micheal Jordan',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12341234'),
                'role' => 'USER',
                'skills' => null,
                'valid_id' => null,
                'job' => null,
                'location' => null,
                'experience' => null,
                'availability' => 0,
                'rating' => null,
                'phone' => '123-456-7890',
                'image' => 'images/image.png',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $workers = [
            [
                'id' => 1,
                'name' => 'Cedric Lee',
                'job' => 'Electrician',
                'location' => 'Amapola Street Purok 2',
                'experience' => 5,
                'availability' => true,
                'rating' => 4,
                'phone' => '123-456-7890',
                'email' => 'worker@gmail.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Charlie', 'rating' => 5, 'text' => 'Amazing craftsmanship!'],
                    ['name' => 'Eve', 'rating' => 4, 'text' => 'Good work, but a bit pricey.']
                ],
                'works' => [
                    ['title' => 'House Wiring', 'description' => 'Completed full house wiring for a two-story home.', 'image' => 'images/image1.png'],
                    ['title' => 'Fuse Box Installation', 'description' => 'Installed and configured a modern fuse box system.', 'image' => 'images/image2.png']
                ]
            ],
            [
                'id' => 2,
                'name' => 'Sasuke Uchiha',
                'job' => 'Carpenter',
                'location' => 'Salang Street Purok 1',
                'experience' => 3,
                'availability' => true,
                'rating' => 3,
                'phone' => '987-654-3210',
                'email' => 'jane.smith@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Charlie', 'rating' => 5, 'text' => 'Amazing craftsmanship!'],
                    ['name' => 'Eve', 'rating' => 4, 'text' => 'Good work, but a bit pricey.']
                ],
                'works' => [
                    ['title' => 'House Wiring', 'description' => 'Completed full house wiring for a two-story home.', 'image' => 'images/image1.png'],
                    ['title' => 'Fuse Box Installation', 'description' => 'Installed and configured a modern fuse box system.', 'image' => 'images/image2.png']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Yujiro Hanma',
                'job' => 'Car Painter',
                'location' => 'Rodriguez Street Purok 5',
                'experience' => 3,
                'availability' => false,
                'rating' => 3,
                'phone' => '987-654-3210',
                'email' => 'alex.johnson@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Charlie', 'rating' => 5, 'text' => 'Amazing craftsmanship!'],
                    ['name' => 'Eve', 'rating' => 4, 'text' => 'Good work, but a bit pricey.']
                ],
                'works' => [
                    ['title' => 'House Wiring', 'description' => 'Completed full house wiring for a two-story home.', 'image' => 'images/image1.png'],
                    ['title' => 'Fuse Box Installation', 'description' => 'Installed and configured a modern fuse box system.', 'image' => 'images/image2.png']
                ]
            ],
            [
                'id' => 4,
                'name' => 'Lebron James',
                'job' => 'Car Electrician',
                'location' => 'Adelfa Street Purok 3',
                'experience' => 3,
                'availability' => false,
                'rating' => 3,
                'phone' => '987-654-3210',
                'email' => 'emily.davis@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Charlie', 'rating' => 5, 'text' => 'Amazing craftsmanship!'],
                    ['name' => 'Eve', 'rating' => 4, 'text' => 'Good work, but a bit pricey.']
                ],
                'works' => [
                    ['title' => 'House Wiring', 'description' => 'Completed full house wiring for a two-story home.', 'image' => 'images/image1.png'],
                    ['title' => 'Fuse Box Installation', 'description' => 'Installed and configured a modern fuse box system.', 'image' => 'images/image2.png']
                ]
            ],
            // Bagong Workers
            [
                'id' => 5,
                'name' => 'Maria Santos',
                'job' => 'Maid',
                'location' => 'Dahlia Street Purok 4',
                'experience' => 4,
                'availability' => true,
                'rating' => 5,
                'phone' => '555-123-4567',
                'email' => 'maria.santos@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'John', 'rating' => 5, 'text' => 'Very thorough and professional!'],
                    ['name' => 'Anna', 'rating' => 5, 'text' => 'Highly recommend her services.']
                ],
                'works' => [
                    ['title' => 'House Cleaning', 'description' => 'Performed deep cleaning for a 3-bedroom house.', 'image' => 'images/image3.png'],
                    ['title' => 'Laundry Service', 'description' => 'Washed and ironed clothes for a family of 5.', 'image' => 'images/image4.png']
                ]
            ],
            [
                'id' => 6,
                'name' => 'Juan Dela Cruz',
                'job' => 'Plumber',
                'location' => 'Sampaguita Street Purok 6',
                'experience' => 6,
                'availability' => true,
                'rating' => 4,
                'phone' => '555-987-6543',
                'email' => 'juan.delacruz@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Mark', 'rating' => 4, 'text' => 'Fixed my pipes quickly!'],
                    ['name' => 'Sarah', 'rating' => 4, 'text' => 'Good service, arrived on time.']
                ],
                'works' => [
                    ['title' => 'Pipe Repair', 'description' => 'Repaired a leaking pipe in the bathroom.', 'image' => 'images/image5.png'],
                    ['title' => 'Water Heater Installation', 'description' => 'Installed a new water heater system.', 'image' => 'images/image6.png']
                ]
            ],
            [
                'id' => 7,
                'name' => 'Ana Reyes',
                'job' => 'Cook',
                'location' => 'Rose Street Purok 7',
                'experience' => 2,
                'availability' => false,
                'rating' => 3,
                'phone' => '555-456-7890',
                'email' => 'ana.reyes@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Peter', 'rating' => 3, 'text' => 'Food was okay, but a bit salty.'],
                    ['name' => 'Lisa', 'rating' => 4, 'text' => 'Great desserts!']
                ],
                'works' => [
                    ['title' => 'Meal Preparation', 'description' => 'Prepared a 3-course meal for a family event.', 'image' => 'images/image7.png'],
                    ['title' => 'Catering Service', 'description' => 'Catered for a small party of 10 people.', 'image' => 'images/image8.png']
                ]
            ],
            [
                'id' => 8,
                'name' => 'Pedro Garcia',
                'job' => 'Driver',
                'location' => 'Tulip Street Purok 8',
                'experience' => 7,
                'availability' => true,
                'rating' => 5,
                'phone' => '555-321-6547',
                'email' => 'pedro.garcia@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'James', 'rating' => 5, 'text' => 'Very reliable driver!'],
                    ['name' => 'Mary', 'rating' => 5, 'text' => 'Always on time and courteous.']
                ],
                'works' => [
                    ['title' => 'Daily Commute', 'description' => 'Drove a client to work daily for a month.', 'image' => 'images/image9.png'],
                    ['title' => 'Long-Distance Trip', 'description' => 'Drove a family to a vacation spot 200km away.', 'image' => 'images/image10.png']
                ]
            ],
            [
                'id' => 9,
                'name' => 'Lina Mercado',
                'job' => 'Tutor',
                'location' => 'Orchid Street Purok 9',
                'experience' => 3,
                'availability' => true,
                'rating' => 4,
                'phone' => '555-654-1234',
                'email' => 'lina.mercado@example.com',
                'image' => 'images/image.png',
                'reviews' => [
                    ['name' => 'Tom', 'rating' => 4, 'text' => 'Helped my son improve in Math!'],
                    ['name' => 'Ella', 'rating' => 4, 'text' => 'Very patient and knowledgeable.']
                ],
                'works' => [
                    ['title' => 'Math Tutoring', 'description' => 'Tutored a high school student in Algebra.', 'image' => 'images/image11.png'],
                    ['title' => 'Science Lessons', 'description' => 'Conducted science experiments for a grade 8 student.', 'image' => 'images/image12.png']
                ]
            ]
        ];
        

        foreach ($workers as $workerData) {
            $user = User::create([
                'name' => $workerData['name'],
                'email' => $workerData['email'],
                'password' => bcrypt('12341234'),
                'role' => 'WORKER',
                'skills' => $workerData['job'],
                'valid_id' => 'worker_valid_id.png',
                'location' => $workerData['location'],
                'experience' => $workerData['experience'],
                'availability' => $workerData['availability'],
                'rating' => $workerData['rating'],
                'phone' => $workerData['phone'],
                'image' => $workerData['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $skilledWorker = SkilledWorker::create([
                'user_id' => $user->id,
                'job' => $workerData['job'],
                'location' => $workerData['location'],
                'experience' => $workerData['experience'],
                'availability' => $workerData['availability'],
                'work_done' => json_encode([]),
                'work_image' => 'images/work_image.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($workerData['reviews'] as $reviewData) {
                $skilledWorker->reviews()->create([
                    'worker_id' => $skilledWorker->id,
                    'name' => $reviewData['name'],
                    'rating' => $reviewData['rating'],
                    'text' => $reviewData['text'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($workerData['works'] as $workData) {
                WorkerWork::create([
                    'worker_id' => $skilledWorker->id,
                    'title' => $workData['title'],
                    'description' => $workData['description'],
                    'image' => $workData['image'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
