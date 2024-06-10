import React, { useEffect, useState } from "react";
import Navbar from "@/components/ui/navbar";
import { useDispatch, useSelector } from "react-redux";
import { fetchPosts, createPost } from "@/features/posts/postSlice";
import { Skeleton } from "@/components/ui/skeleton";
import { Contact2, ThumbsUp } from "lucide-react";
import { CiChat1 } from "react-icons/ci";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { IoHomeOutline } from "react-icons/io5";
import { VscAccount } from "react-icons/vsc";
import { Separator } from "@/components/ui/separator";

const HomePage = () => {
  const dispatch = useDispatch();
  const { posts, status, error } = useSelector((state) => state.posts);

  const [content, setContent] = useState("");

  useEffect(() => {
    dispatch(fetchPosts());
  }, [dispatch]);

  const handleCreatePost = (e) => {
    e.preventDefault();
    const newPost = { content };
    dispatch(createPost(newPost));
    setContent("");
  };

  return (
    <div className="w-full min-h-screen flex flex-col bg-gray-100">
      <Navbar />
      <div className="flex h-full lg:mt-20">
        {/* sidebar */}
        <div className=" w-[22%]  hidden lg:block">
          <div className="h-[88%] fixed left-0 top-20 w-[18%]  bg-white ">
            <ul className="h-full flex flex-col gap-2 ">
              <li className=" px-10 mt-4">
                <a className="btn btn-ghost text-base font-light flex items-center justify-start w-full">
                  <IoHomeOutline className="h-6 w-6" /> Home
                </a>
              </li>
              <li className=" px-10 ">
                <a className="btn btn-ghost text-base font-light flex items-center justify-start w-full">
                  <VscAccount className="h-6 w-6" /> Profile
                </a>
              </li>
              <Separator />
            </ul>
          </div>
        </div>
        <div className="lg:w-[80%] w-full mx-auto px-4 py-8 sm:px-6 ">
          {/* Create Post Section */}
          <div className="bg-white shadow-sm rounded-md p-4 sm:p-6 mb-6">
            <h2 className="text-lg font-semibold text-gray-900 mb-4">
              Create a New Post
            </h2>
            <form onSubmit={handleCreatePost}>
              <div className="mb-4">
                <label
                  htmlFor="content"
                  className="block text-sm font-medium text-gray-700"
                >
                  Content
                </label>
                <textarea
                  id="content"
                  value={content}
                  onChange={(e) => setContent(e.target.value)}
                  className="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  placeholder="Enter post content"
                  rows="4"
                  required
                />
              </div>
              <div className="flex justify-end">
                <button
                  type="submit"
                  className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Create Post
                </button>
              </div>
            </form>
          </div>

          {status === "loading" && (
            <div className="space-y-2 w-full">
              {Array.from({ length: posts?.data?.length || 3 }).map(
                (_, index) => (
                  <Skeleton key={index} className="h-36 w-full bg-gray-200" />
                )
              )}
            </div>
          )}
          {status === "failed" && <p>Error: {error}</p>}
          {status === "succeeded" && (
            <ul className="space-y-4">
              {posts.data.map((post) => (
                <li
                  key={post.id}
                  className="bg-white shadow-sm rounded-md p-4 lg:p-2 sm:p-6"
                >
                  <span className="text-sm flex items-center gap-2 text-gray-600 ">
                    <Avatar className="cursor-pointer mr-1">
                      <AvatarImage src="https://github.com/shadcn.png" />
                      <AvatarFallback>CN</AvatarFallback>
                    </Avatar>
                    <span className="text-slate-900 font-semibold">
                      {post.user ? post.user.name : "Unknown"}
                    </span>{" "}
                    •{" "}
                    <span className="">
                      {new Date(post.created_at).toLocaleDateString()}
                    </span>
                  </span>

                  <p className="text-lg font-semibold text-gray-900 mb-2 py-2">
                    {post.content}
                  </p>
                  <div className="mt-2 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div className="flex space-x-4 mt-2 sm:mt-0">
                      <span className="text-sm text-gray-600 flex items-center justify-center gap-2 bg-slate-200 rounded-lg py-2 px-3">
                        <ThumbsUp className="w-4 h-4" />
                        {post.likes_count}
                      </span>
                      <span className="text-sm text-gray-600 flex items-center justify-center gap-2 bg-slate-200 rounded-lg py-2 px-3">
                        <CiChat1 className="w-4 h-4" />
                        {post.comments_count}
                      </span>
                    </div>
                  </div>
                </li>
              ))}
            </ul>
          )}
        </div>
        <div className=" w-[22%]  hidden lg:block">
          <div className="h-[88%] fixed right-0 top-20 w-[18%]  bg-white ">
            <ul className="h-full flex flex-col gap-2 ">
              <li className=" px-10 mt-4">
                <a className="btn btn-ghost text-base font-light flex items-center justify-center w-full">
                  <Contact2 /> Contacts
                </a>
              </li>
              <Separator />
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">
                  Shadman
                </span>
              </li>
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">Marcus</span>
              </li>
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">
                  Bellammy
                </span>
              </li>
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">Clarke</span>
              </li>
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">Mark</span>
              </li>
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">Monty</span>
              </li>
              <li className="flex items-center justify-start gap-3 px-4 py-2">
                <Avatar className="">
                  <AvatarImage src="https://github.com/shadcn.png" />
                  <AvatarFallback>CN</AvatarFallback>
                </Avatar>
                <span className="text-sm text-gray-600 font-light">Raven</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  );
};

export default HomePage;
