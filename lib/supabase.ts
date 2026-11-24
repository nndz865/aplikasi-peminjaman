import { createClient } from '@supabase/supabase-js';

const supabaseUrl = process.env.NEXT_PUBLIC_SUPABASE_URL || 'https://cnrughmqjgldoiivvqmp.supabase.co';
const supabaseAnonKey = process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY || 'sb_publishable_tVvHuQhUgdNObE8XF1-qMg_0lIJVq45';

export const supabase = createClient(supabaseUrl, supabaseAnonKey);
