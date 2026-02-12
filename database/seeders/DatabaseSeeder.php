<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;
use App\Models\VirtualGift;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gravespace.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $memorial = Memorial::create([
            'user_id' => $user->id,
            'slug' => 'john-doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1945-03-15',
            'date_of_death' => '2024-11-20',
            'place_of_birth' => 'New York, NY',
            'place_of_death' => 'Los Angeles, CA',
            'obituary' => 'John Doe was a beloved father, grandfather, and friend. Born in New York City, he lived a life full of adventure and compassion. He served his community with dedication and was known for his warm smile and generous spirit. John touched the lives of everyone he met, leaving behind a legacy of kindness and love that will endure for generations.',
            'privacy' => 'public',
            'is_published' => true,
            'cemetery_name' => 'Forest Lawn Memorial Park',
            'cemetery_address' => '1712 S Glendale Ave, Glendale, CA 91205',
        ]);

        Tribute::create([
            'memorial_id' => $memorial->id,
            'author_name' => 'Jane Smith',
            'body' => 'John was one of the kindest souls I have ever known. He always had a warm smile and a helping hand for anyone in need. Rest in peace, dear friend.',
            'is_approved' => true,
        ]);

        Tribute::create([
            'memorial_id' => $memorial->id,
            'author_name' => 'Robert Johnson',
            'body' => 'I will never forget the summers we spent together. John had a way of making every moment special. He will be deeply missed.',
            'is_approved' => true,
        ]);

        VirtualGift::create([
            'memorial_id' => $memorial->id,
            'type' => 'candle',
            'message' => 'Rest in peace',
        ]);

        VirtualGift::create([
            'memorial_id' => $memorial->id,
            'type' => 'flower',
            'message' => 'Forever in our hearts',
        ]);

        VirtualGift::create([
            'memorial_id' => $memorial->id,
            'type' => 'candle',
        ]);

        // Person born on February 12
        Memorial::create([
            'user_id' => $user->id,
            'slug' => 'elena-petrova',
            'first_name' => 'Elena',
            'last_name' => 'Petrova',
            'date_of_birth' => '1938-02-12',
            'date_of_death' => '2021-09-03',
            'place_of_birth' => 'Sofia, Bulgaria',
            'place_of_death' => 'Plovdiv, Bulgaria',
            'obituary' => 'Elena Petrova was a beloved teacher and poet who inspired generations of students with her passion for literature and the arts. Born on this day in 1938, she dedicated her life to nurturing young minds and preserving cultural heritage. Her warmth and wisdom touched everyone she met.',
            'privacy' => 'public',
            'is_published' => true,
        ]);

        // Person who died on February 12
        Memorial::create([
            'user_id' => $user->id,
            'slug' => 'marcus-wright',
            'first_name' => 'Marcus',
            'last_name' => 'Wright',
            'date_of_birth' => '1952-06-28',
            'date_of_death' => '2023-02-12',
            'place_of_birth' => 'Chicago, IL',
            'place_of_death' => 'Denver, CO',
            'obituary' => 'Marcus Wright was a devoted community leader, loving husband, and proud grandfather. A veteran and lifelong advocate for education, Marcus spent decades mentoring young people and building bridges across communities. He passed away on this day in 2023, leaving behind a legacy of service and compassion.',
            'privacy' => 'public',
            'is_published' => true,
        ]);
    }
}
