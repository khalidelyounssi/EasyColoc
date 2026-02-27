<x-app-layout>
    <div class="flex min-h-screen bg-[#FAFAFA] font-sans antialiased text-[#1D1D1F]">
        
        @include('layouts.navigation')

        <main class="flex-1 ml-72">
            <div class="py-12 px-12 max-w-7xl mx-auto space-y-12">
                
                <header class="flex justify-between items-end">
                    <div>
                        <h1 class="text-6xl font-black tracking-tighter uppercase italic leading-none">Global Control</h1>
                        <p class="text-indigo-500 text-[10px] font-bold uppercase tracking-[0.3em] mt-4 italic">Platform Monitoring & Security</p>
                    </div>
                    <div class="bg-black text-white px-8 py-3 rounded-2xl text-[10px] font-bold uppercase tracking-widest italic shadow-xl">
                        Node: Admin-01
                    </div>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    @php
                        $stats_items = [
                            ['label' => 'Total Users', 'value' => $stats['total_users'], 'icon' => '👥', 'color' => 'text-black'],
                            ['label' => 'Active Spaces', 'value' => $stats['total_colocations'], 'icon' => '🏠', 'color' => 'text-indigo-600'],
                            ['label' => 'Global Volume', 'value' => number_format($stats['total_expenses'], 0) . ' DH', 'icon' => '💰', 'color' => 'text-black'],
                            ['label' => 'Banned Nodes', 'value' => $stats['banned_users'], 'icon' => '🚫', 'color' => 'text-red-500'],
                        ];
                    @endphp

                    @foreach($stats_items as $item)
                        <div class="bg-white p-10 rounded-[3rem] border border-[#F5F5F7] shadow-sm hover:shadow-2xl transition-all duration-500 group">
                            <div class="flex justify-between items-start mb-6">
                                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest italic">{{ $item['label'] }}</span>
                                <span class="text-xl">{{ $item['icon'] }}</span>
                            </div>
                            <p class="text-5xl font-black italic tracking-tighter {{ $item['color'] }}">{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white rounded-[3.5rem] p-12 border border-[#F5F5F7] shadow-sm">
                    <div class="flex justify-between items-center mb-12 px-4">
                        <h3 class="text-xl font-bold italic uppercase tracking-tighter">User Directory</h3>
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Live Feed</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead>
                                <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">
                                    <th class="px-8 pb-4">User Identity</th>
                                    <th class="px-8 pb-4">Reputation</th>
                                    <th class="px-8 pb-4">System Status</th>
                                    <th class="px-8 pb-4 text-right">Moderation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="bg-[#FAFAFA] rounded-[2.5rem] overflow-hidden group hover:bg-white hover:shadow-lg transition-all duration-300 border border-transparent hover:border-gray-50">
                                    <td class="px-8 py-8">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center text-white font-bold text-xs italic">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-sm italic uppercase tracking-tight">{{ $user->name }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium lowercase">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-8 font-black italic text-indigo-500">
                                        {{ $user->reputation_score ?? 0 }}
                                    </td>
                                    <td class="px-8 py-8">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase italic tracking-widest {{ $user->is_banned ? 'bg-red-50 text-red-500' : 'bg-green-50 text-green-600' }}">
                                            {{ $user->is_banned ? 'Banned' : 'Active' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-8 text-right">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-ban', $user->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-white border border-gray-100 px-8 py-3 rounded-full text-[9px] font-black uppercase italic tracking-widest hover:bg-black hover:text-white transition-all shadow-sm">
                                                    {{ $user->is_banned ? 'Restore Access' : 'Restrict Access' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-300 uppercase italic px-8">Root Admin</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-12 px-6 italic">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>