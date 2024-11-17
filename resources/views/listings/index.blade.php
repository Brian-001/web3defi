@foreach ($listings as $listing )
    <div class="bg-slate-600 hover:bg-slate-800 p-4 rounded-lg hover:shadow-md hover:shadow-cyan-400 max-h-96">
        <div class="flex flex-col gap-2">
            <div class="sm:hidden md:flex items-center justify-center mb-2">
                <img src="{{asset('storage/' . $listing->listing_logo)}}" alt="Company Logo" class="w-40 h-40 mr-4 bg-cover rounded-md">
            </div>

            <div class="box3">
                <div class="title">
                    <h3 class="text-xl text-center mb-2">{{$listing->listing_title}}</h3>
                </div>
                <div class="description mb-2 relative overflow-hidden">
                    <p class="text-sm text-gray-300 text-pretty overflow-hidden whitespace-nowrap text-ellipsis">
                        {{-- Truncates job description to 100 characters --}}
                        {{Str::limit($listing->job_description, 100)}} 
                    </p>
                </div>
                <div class="tags flex flex-wrap gap-2 mb-2">
                    @foreach (explode(',',$listing->tags) as $tag )
                        <span class="bg-white text-slate-700 text-sm px-2 py-0.5 rounded-full">{{$tag}}</span>
                    @endforeach
                </div>
                <div class="flex justify-between">
                    <div class="location_salary flex flex-col">
                        <p class="mb-2 text-sm">Location: {{$listing->location}}</p>
                        <p class="mb-2 text-sm">Salary: {{$listing->salary}}</p>
                    </div>
                    <div class="flex items-baseline">
                        <button class="bg-cyan-300 text-slate-700 px-2 py-1.5 rounded-md">Learn more</button>
                    </div>
                </div>                        
            </div>
        </div>
    </div>  
@endforeach