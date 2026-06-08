{{-- resources/views/components/course-card.blade.php --}}
@props(['course'])

<a href="{{ route('student.courses.show', $course) }}"
   class="group block bg-white rounded-xl border border-gray-200
          hover:shadow-md hover:border-indigo-200 transition-all duration-200">

    {{-- Imagen de portada --}}
    <div class="aspect-video bg-gray-100 rounded-t-xl overflow-hidden">
        @if($course->cover_image)
            <img src="{{ asset('storage/' . $course->cover_image) }}"
                 alt="{{ $course->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300 text-4xl">
                🎓
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-4">
        <span class="text-xs text-indigo-500 font-medium">
            {{ ucfirst($course->level) }}
        </span>
        <h3 class="font-medium text-gray-900 mt-1 group-hover:text-indigo-600">
            {{ $course->title }}
        </h3>
        <p class="text-sm text-gray-500 mt-1 line-clamp-2">
            {{ $course->description }}
        </p>
        <div class="flex items-center justify-between mt-3">
            <span class="text-xs text-gray-500">
                {{ $course->instructor->name }}
            </span>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400">
                    {{ $course->lessons_count ?? 0 }} lecciones
                </span>
                @if($course->active)
                    <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">
                        Activo
                    </span>
                @else
                    <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded-full">
                        Inactivo
                    </span>
                @endif
            </div>
        </div>
    </div>

</a>