<div class="flex items-center justify-center">
    <form action="#">
        @csrf
        {{-- listing_title --}}
        <div class="mb-4">
            <input type="text" name="listing_title" id="listing_title">
        </div>

        {{-- company_description --}}
        <div class="mb-4">
            <textarea name="company_description" id="company_description" cols="30" rows="10" placeholder="Optional">

            </textarea>
        </div>

        {{-- job_description --}}
        <div class="mb-4">
            <textarea name="job_description" id="job_description" cols="30" rows="10" placeholder="Enter job description">

            </textarea>
        </div>

        {{--job roles --}}
        <div class="mb-4">
            <textarea name="job_roles" id="job_roles" cols="30" rows="10" placeholder="enter roles and responsibilities">

            </textarea>
        </div>
        {{-- Additional Information --}}
        <div class="mb-4">
            <textarea name="additiional_info" id="additional_info" cols="30" rows="10"></textarea>
        </div>
        {{-- tags --}}
        <div class="mb-4">
            <select name="tags" id="tags">
                <option value="Laravel">Laravel</option>
                <option value="javaScript">JavaScript</option>
                <option value="Java">Java</option>
                <option value="Golang">Golang</option>
                <option value="Rust">Rust</option>
            </select>
        </div>
        {{-- location --}}
        <div class="mb-4">
            <input type="text" name="location" id="location" placeholder="City, Country">
        </div>
        {{-- salary --}}
        <div class="mb-4">
            <input type="number" name="salary" id="salary">
        </div>
        {{-- job-type --}}
        <div class="mb-4">
            <select name="" id="">
                <option value="onsite">On-site</option>
                <option value="remote">Remote</option>
                <option value="hybrid">Hybrid</option>
            </select>
        </div>
    </form>
</div>