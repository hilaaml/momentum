@props(['project'])

<form method="POST" action="{{ route('tasks.store') }}"
      class="mt-3 flex items-center gap-4">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <input name="name" placeholder="+ Tambah Task" required
           class="flex-1 bg-transparent placeholder-gray-500/75 border-b border-gray-300/50 focus:border-indigo-600 focus:outline-none py-2 text-sm" />
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Tambah</button>
</form>
