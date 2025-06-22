<x-layout :title="$title">
    <div class="p-8 mx-auto max-w-3xl bg-white rounded-2xl shadow-lg shadow-gray-100">
        <h2 class="text-3xl text-slate-900 font-bold">Let's Talk</h2>
        <p class="text-[15px] text-slate-600 mt-3 leading-relaxed">Have some big idea or brand to develop and need help? Then reach out we'd love to hear about your project  and provide help.</p>
        <form class="mt-8 space-y-5">
          <div>
            <label class='text-sm text-slate-900 font-medium mb-2 block'>Name</label>
            <input type='text' placeholder='Enter Name'
              class="w-full rounded-lg py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />
          </div>
          <div>
            <label class='text-sm text-slate-900 font-medium mb-2 block'>Email</label>
            <input type='email' placeholder='Enter Email'
              class="w-full rounded-lg py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />
          </div>
          <div>
            <label class='text-sm text-slate-900 font-medium mb-2 block'>Message</label>
            <textarea placeholder='Enter Message' rows="6"
              class="w-full rounded-lg px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm pt-3 outline-0 transition-all"></textarea>
          </div>
          <button type='button'
            class="text-white bg-slate-900 font-medium hover:bg-slate-800 tracking-wide text-sm px-4 py-3 w-full rounded-lg border-0 outline-0 cursor-pointer">Send message</button>
        </form>
      </div>
</x-layout>